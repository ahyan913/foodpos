/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

import './bootstrap';

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import './components/Page/Index';

import { getCookie } from './utils/Cookie';

import "../css/app.css";

import i18n from "i18next";
import zh_HK from '../lang/zh_HK';
import { initReactI18next } from "react-i18next";
i18n.use(initReactI18next)
.init({
    resources:{
        zh_HK:{
            translation: zh_HK
        }
    },
    lng:"en_US",
    fallbackLng:"en_US",
    interpolation:{
        escapeValue:false,
        prefix: ':\\b',
        suffix: '(?:\\b)'
    }
});

const cookieLocale = getCookie("locale");
if(cookieLocale){
    i18n.changeLanguage(cookieLocale);
}

