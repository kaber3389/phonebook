<?php
/**
 * @var \app\models\Contact[] $contacts
 */

$this->title = 'Телефонный справочник ООО «Новороссийский прокатный завод»';
?>
<div class="body-content">
        <div class="preloader" v-if="loading">
            <svg class="preloader__image" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path fill="currentColor"
                      d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                </path>
            </svg>
        </div>
    <transition name="fade" mode="out-in">
        <div class="row" v-show="!loading">
            <div id="navigation">
                <table width="100%" class="table-top">
                    <thead>
                    <tr>
                        <th width="25%">ФИО</th>
                        <th width="25%">Почта</th>
                        <th width="25%">Телефон</th>
                        <th width="25%">Должность</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <div class="table-content-wrapper">
                <div v-for="(department, index, key) in contacts" class="table-content">
                    <div v-if="index">
                        <span><b v-html="containsSearch(index).toUpperCase()"></b></span>
                        <?php /*
                        <span class="table-toggle">
                            <i :id="`i_` + `${key}`"
                               class="glyphicon glyphicon-menu-down"
                               @click="toggle(key)"
                               aria-hidden="true"></i>
                        </span> */?>
                    </div>
                    <table :id="`table_` + `${key}`"
                           class="table table-striped table-hover"
                           v-if="contacts[index].length">
                        <tbody>
                        <tr v-for="contact in contacts[index]" v-show="showContacts">
                            <td width="25%" v-html="containsSearch(contact.full_name)"></td>
                            <td width="25%"><a :href="`mailto:${contact.email}`" v-html="containsSearch(contact.email)"></a></td>
                            <td width="25%" v-html="containsSearch(contact.phone)"></td>
                            <td width="25%" v-html="containsSearch(contact.position)"></td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                </div>
            </div>
        </div>
    </transition>
</div>
