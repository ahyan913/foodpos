import React, {useState, useEffect, forwardRef } from 'react';
import i18n from 'i18next';
import {useTranslation} from 'react-i18next';
import ActionSheet from 'actionsheet-react';
import { setCookie } from '../../../utils/Cookie';
import CloseButton from '../../Buttons/Default/CloseButton';

export default forwardRef(function Locale(props, ref){

    const {t} = useTranslation();

    const close = ()=>{
        ref.current.close();
    }

    const changeLanguage = (locale)=>{
        setCookie("locale", locale, 1);
        i18n.changeLanguage(locale);
        close();
    }

    return (
        <ActionSheet ref={ref} sheetTransition="transform 0.2s ease-in-out" >
            <div className="sticky justify-end top-0 shadow p-6 dark:bg-slate-800">
                <div className="flex justify-between">
                    <h2 className="text-xl">{t("Please select your language")}</h2>
                    <CloseButton onClick={close}></CloseButton>
                </div>
            </div>
            <div className="p-3 dark:bg-slate-800">
                <div className="store-list grid gap-3 lg:grid-cols-6 p-3" >
                    <nav className="flex gap-6 flex-col">
                        <a className="cursor-pointer" onClick={()=>changeLanguage("en_US")}>{ t("English") }</a>
                        <a className="cursor-pointer" onClick={()=>changeLanguage("zh_HK")}>{ t("繁體中文") }</a>
                    </nav>
                </div>
            </div>
        </ActionSheet>
    );

});
