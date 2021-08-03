<?php
namespace app\commands;

use app\models\Contact;
use yii\base\Exception;
use yii\console\Controller;

class ContactController extends Controller
{
    const USER_DISABLED_CODE = '514';
    const USER_EXPIRED_CODE = '66050';

    public function actionLoad()
    {
        $config = \Yii::$app->params['ldapConfig'];
        $ad = new \Adldap\Adldap();

        $ad->addProvider($config);
        $provider = $ad->connect();
        $users = $provider
            ->search()
            ->where('mail', 'contains', '@')
            ->where('userAccountControl', '!', self::USER_DISABLED_CODE)
            ->where('userAccountControl', '!', self::USER_EXPIRED_CODE)
            ->get();

        echo "START \n";
        $contactIds = [];
        foreach ($users as $user)
        {
            $contact = Contact::findOne([
                'full_name' => $user->getDisplayName(),
                'phone' => $user->getPhone(),
                'email' => $user->getEmail()
            ]);
            if (!$contact)
                $contact = new Contact();

            /**
             * @var $user \Adldap\Models\User
             */
            $contact->full_name = $user->getDisplayName();
            $contact->email = $user->getEmail();
            $contact->phone = $user->getPhone();
            $contact->department = $user->getDepartment();
            $contact->position = $user->getTitle();
            $contact->is_active = 1;

            if (!$contact->save())
                throw new Exception($contact->getErrors());
            else
                $this->stdout("SAVED: {$contact->email} \n");

            $contactIds[] = $contact->id;
        }

        echo 11111111111111111111;

        echo "Total users: " . count($users) . "\n";
        echo "END \n";

        $disabledContacts= Contact::find()
            ->andWhere(['is_active' => 1])
            ->andWhere(['not in', 'id', $contactIds])
            ->all();

        foreach ($disabledContacts as $disabledContact)
        {
            /** @var $disabledContact Contact */
            $disabledContact->is_active = 0;
            if (!$disabledContact->save())
                throw new Exception($disabledContact->getErrors());
            else
                $this->stdout("Updated: {$disabledContact->email} \n");
        }

        foreach (Contact::find()->all() as $contact)
        {
            if (!$contact->email)
            {
                $contact->is_active = 0;
                if (!$contact->save())
                    throw new Exception($contact->getErrors());
            }
        }
    }
}