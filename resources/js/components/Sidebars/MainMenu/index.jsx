import React from "react";
import { useTranslation } from "react-i18next";

import Drawer from 'react-modern-drawer';
import 'react-modern-drawer/dist/index.css';
import { useDarkmode, useUpdateDarkmode } from "../../Contexts/Darkmode";
import IconButton from "../../Buttons/Default/IconButton";
import CloseButton from "../../Buttons/Default/CloseButton";

export default function Sidebar({ openStoreMenu, setIsOpen, isOpen }){

    const { t } = useTranslation();

    const close = ()=>{
        setIsOpen(false);
    }


    const darkMode = useDarkmode();
    const toggleDarkmode = useUpdateDarkmode();


    const comingsoon = () =>{
        alert(t("Coming Soon"));
    }

    return (
        <Drawer
                open={isOpen}
                onClose={close}
                direction='right'
                className='!w-full dark:!bg-gray-800'
            >

            <div className="flex justify-between p-3 dark:text-white">
                <h2 className="text-xl ">{t("Menu")}</h2>
                <CloseButton onClick={close}></CloseButton>
            </div>

            <div className="py-4 overflow-y-auto p-3">
                <h2 className="border-b-2 pb-3 dark:text-white ">{t("General")}</h2>
                <nav className="space-y-2 font-medium grid grid-cols-4 items-end">

                    <IconButton onClick={openStoreMenu}>
                        <svg fill="currentColor" className="w-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M18 9.87V20H2V9.87a4.25 4.25 0 0 0 3-.38V14h10V9.5a4.26 4.26 0 0 0 3 .37zM3 0h4l-.67 6.03A3.43 3.43 0 0 1 3 9C1.34 9 .42 7.73.95 6.15L3 0zm5 0h4l.7 6.3c.17 1.5-.91 2.7-2.42 2.7h-.56A2.38 2.38 0 0 1 7.3 6.3L8 0zm5 0h4l2.05 6.15C19.58 7.73 18.65 9 17 9a3.42 3.42 0 0 1-3.33-2.97L13 0z"/></svg>
                        { t("Stores") }
                    </IconButton>

                    <IconButton onClick={toggleDarkmode}>
                        {
                            darkMode ?
                            <svg fill="currentColor" className="w-6" enableBackground="new 0 0 32 32" id="Outline" version="1.1" viewBox="0 0 32 32" xmlSpace="preserve" xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink"><title/><desc/><g><path d="M16,26c-5.514,0-10-4.486-10-10S10.486,6,16,6s10,4.486,10,10S21.514,26,16,26z M16,8c-4.411,0-8,3.589-8,8s3.589,8,8,8   s8-3.589,8-8S20.411,8,16,8z"/><rect height="4" width="2" x="15"/><rect height="4" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -2.5269 6.1006)" width="2" x="5.101" y="4.101"/><rect height="2" width="4" y="15"/><rect height="2" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -16.5268 11.8995)" width="4" x="4.101" y="24.9"/><rect height="4" width="2" x="15" y="28"/><rect height="4" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -10.7279 25.8994)" width="2" x="24.9" y="23.9"/><rect height="2" width="4" x="28" y="15"/><rect height="2" transform="matrix(0.7071 -0.7071 0.7071 0.7071 3.272 20.1005)" width="4" x="23.9" y="5.101"/></g></svg>
                            :
                            <svg fill="currentColor" className="w-6" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M421.6 379.9c-.6641 0-1.35 .0625-2.049 .1953c-11.24 2.143-22.37 3.17-33.32 3.17c-94.81 0-174.1-77.14-174.1-175.5c0-63.19 33.79-121.3 88.73-152.6c8.467-4.812 6.339-17.66-3.279-19.44c-11.2-2.078-29.53-3.746-40.9-3.746C132.3 31.1 32 132.2 32 256c0 123.6 100.1 224 223.8 224c69.04 0 132.1-31.45 173.8-82.93C435.3 389.1 429.1 379.9 421.6 379.9zM255.8 432C158.9 432 80 353 80 256c0-76.32 48.77-141.4 116.7-165.8C175.2 125 163.2 165.6 163.2 207.8c0 99.44 65.13 183.9 154.9 212.8C298.5 428.1 277.4 432 255.8 432z"/></svg>
                        }
                        { darkMode ? t("Light"):t("Night") }
                    </IconButton>
                </nav>
            </div>

        </Drawer>
    )

};
