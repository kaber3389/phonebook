<?php
namespace app\models;

/**
 * Class Category
 * @package common\models
 *
 * @property integer $id
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $department
 * @property string $position
 * @property integer $order
 * @property integer $is_active
 */
class Contact extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'contact';
    }
    public function rules(): array
    {
        return [
            [['is_active', 'order'], 'integer'],
            [['full_name', 'email', 'phone', 'department', 'position'], 'string']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'full_name' => 'Название',
            'email' => 'Продукты',
            'phone' => 'Телефон',
            'department' => 'Отдел',
            'position' => 'Должность',
            'order' => 'Сортировка',
            'is_active' => 'Включен',
        ];
    }

}