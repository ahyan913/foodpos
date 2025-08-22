import React , { useState, useEffect } from "react";
import { useTranslation } from 'react-i18next';
import { useSpeechRecognition } from "react-speech-kit";
import { useCart } from "../../Contexts/Cart";
import IconButton from "../../Buttons/Default/IconButton";
import CloseButton from "../../Buttons/Default/CloseButton";
import { useProduct } from "../../Contexts/Product";


export default function Menu({ openLocaleMenu, openMainmenu }){

    const { t, i18n } = useTranslation();
    const { getTotalItemsQty, checkout } = useCart();
    const [isSearchBarOpened, setIsSearchBarOpened] = useState(false);
    const badge = getTotalItemsQty();
    const [showSearchBar, setShowSearchBar] = useState(false);
    const { searchText, setSearchText } = useProduct();
    const [isListening, setIsListening] = useState(false);
    const {listen, supported, listening, stop } = useSpeechRecognition({
        onResult:(result)=>{  console.log(result); setSearchText(result)}
    });

    const voiceSearch = ()=>{
        listen({lang:i18n.language});
    }


    const hideSearchBar = () => {

        setShowSearchBar(false);
        setTimeout(()=>{
            setIsSearchBarOpened(false);
        },500);
    }

    const displaySearchBar = () => {
        setIsSearchBarOpened(true);
        setShowSearchBar(true);
    }

    return (
        <div className="fixed bottom-0 z-50 w-full  bg-white border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600 ">
            {
            !isSearchBarOpened ?
            (
            <div className="flex items-end justify-content lg:max-w-lg lg:mx-auto relative">
                <IconButton onClick={checkout} badge={badge}>
                    <svg fill="currentColor" className="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" baseProfile="tiny" version="1.2" xmlSpace="preserve" xmlnsXlink="http://www.w3.org/1999/xlink"><g id="Layer_1"><g><path d="M20.756,5.345C20.565,5.126,20.29,5,20,5H6.181L5.986,3.836C5.906,3.354,5.489,3,5,3H2.75c-0.553,0-1,0.447-1,1    s0.447,1,1,1h1.403l1.86,11.164c0.008,0.045,0.031,0.082,0.045,0.124c0.016,0.053,0.029,0.103,0.054,0.151    c0.032,0.066,0.075,0.122,0.12,0.179c0.031,0.039,0.059,0.078,0.095,0.112c0.058,0.054,0.125,0.092,0.193,0.13    c0.038,0.021,0.071,0.049,0.112,0.065C6.748,16.972,6.87,17,6.999,17C7,17,18,17,18,17c0.553,0,1-0.447,1-1s-0.447-1-1-1H7.847    l-0.166-1H19c0.498,0,0.92-0.366,0.99-0.858l1-7C21.031,5.854,20.945,5.563,20.756,5.345z M18.847,7l-0.285,2H15V7H18.847z M14,7    v2h-3V7H14z M14,10v2h-3v-2H14z M10,7v2H7C6.947,9,6.899,9.015,6.852,9.03L6.514,7H10z M7.014,10H10v2H7.347L7.014,10z M15,12v-2    h3.418l-0.285,2H15z"/><circle cx="8.5" cy="19.5" r="1.5"/><circle cx="17.5" cy="19.5" r="1.5"/></g></g></svg>
                    { t("Order") }
                </IconButton>

                <IconButton onClick={openLocaleMenu}>
                    <svg fill="currentColor" className="w-6 h-6" version="1.1" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlnsXlink="http://www.w3.org/1999/xlink"><title/><desc/><defs/><g fill="none" fillRule="evenodd" id="Page-1" stroke="none" strokeWidth="1"><g fill="currentColor" id="Core" transform="translate(-296.000000, -296.000000)"><g id="language" transform="translate(296.000000, 296.000000)"><path d="M10,0 C4.5,0 0,4.5 0,10 C0,15.5 4.5,20 10,20 C15.5,20 20,15.5 20,10 C20,4.5 15.5,0 10,0 L10,0 Z M16.9,6 L14,6 C13.7,4.7 13.2,3.6 12.6,2.4 C14.4,3.1 16,4.3 16.9,6 L16.9,6 Z M10,2 C10.8,3.2 11.5,4.5 11.9,6 L8.1,6 C8.5,4.6 9.2,3.2 10,2 L10,2 Z M2.3,12 C2.1,11.4 2,10.7 2,10 C2,9.3 2.1,8.6 2.3,8 L5.7,8 C5.6,8.7 5.6,9.3 5.6,10 C5.6,10.7 5.7,11.3 5.7,12 L2.3,12 L2.3,12 Z M3.1,14 L6,14 C6.3,15.3 6.8,16.4 7.4,17.6 C5.6,16.9 4,15.7 3.1,14 L3.1,14 Z M6,6 L3.1,6 C4.1,4.3 5.6,3.1 7.4,2.4 C6.8,3.6 6.3,4.7 6,6 L6,6 Z M10,18 C9.2,16.8 8.5,15.5 8.1,14 L11.9,14 C11.5,15.4 10.8,16.8 10,18 L10,18 Z M12.3,12 L7.7,12 C7.6,11.3 7.5,10.7 7.5,10 C7.5,9.3 7.6,8.7 7.7,8 L12.4,8 C12.5,8.7 12.6,9.3 12.6,10 C12.6,10.7 12.4,11.3 12.3,12 L12.3,12 Z M12.6,17.6 C13.2,16.5 13.7,15.3 14,14 L16.9,14 C16,15.7 14.4,16.9 12.6,17.6 L12.6,17.6 Z M14.4,12 C14.5,11.3 14.5,10.7 14.5,10 C14.5,9.3 14.4,8.7 14.4,8 L17.8,8 C18,8.6 18.1,9.3 18.1,10 C18.1,10.7 18,11.4 17.8,12 L14.4,12 L14.4,12 Z" id="Shape"/></g></g></g></svg>
                    { t("Locale") }
                </IconButton>

                <IconButton onClick={openMainmenu}>
                    <svg  fill="currentColor" className="w-6 h-6" version="1.1" viewBox="0 0 16 16" xmlSpace="preserve" xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink"><circle cx="2" cy="8" r="2"/><circle cx="8" cy="8" r="2"/><circle cx="14" cy="8" r="2"/></svg>
                    { t("Menu") }
                </IconButton>
                <IconButton onClick={displaySearchBar}>
                    <svg fill="currentColor" className="w-6 h-6" enableBackground="new 0 0 32 32" id="Glyph" version="1.1" viewBox="0 0 32 32" xmlSpace="preserve" xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink"><path d="M27.414,24.586l-5.077-5.077C23.386,17.928,24,16.035,24,14c0-5.514-4.486-10-10-10S4,8.486,4,14  s4.486,10,10,10c2.035,0,3.928-0.614,5.509-1.663l5.077,5.077c0.78,0.781,2.048,0.781,2.828,0  C28.195,26.633,28.195,25.367,27.414,24.586z M7,14c0-3.86,3.14-7,7-7s7,3.14,7,7s-3.14,7-7,7S7,17.86,7,14z" id="XMLID_223_"/></svg>
                    { t("Search") }
                </IconButton>
            </div>
            ):
            (
                <div className=" w-full p-3 basis-100 flex justify-end">
                    <div className={"flex items-center border-4 rounded-full px-3 "+(showSearchBar ?  "animate-expand" : "animate-shrink") }>
                        <svg fill="currentColor" className="w-6 h-6" enableBackground="new 0 0 32 32" id="Glyph" version="1.1" viewBox="0 0 32 32" xmlSpace="preserve" xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink"><path d="M27.414,24.586l-5.077-5.077C23.386,17.928,24,16.035,24,14c0-5.514-4.486-10-10-10S4,8.486,4,14  s4.486,10,10,10c2.035,0,3.928-0.614,5.509-1.663l5.077,5.077c0.78,0.781,2.048,0.781,2.828,0  C28.195,26.633,28.195,25.367,27.414,24.586z M7,14c0-3.86,3.14-7,7-7s7,3.14,7,7s-3.14,7-7,7S7,17.86,7,14z" id="XMLID_223_"/></svg>
                        <input type="text" className="text-sm p-2 basis-full focus:outline-none ring-none border-none bg-transparent" onChange={(e)=>{ setSearchText(e.target.value) }} placeholder={t("Search Product")} value={searchText} />
                        <button onClick={()=>setSearchText("")}  className={"w-6 mx-3"}>
                            <svg fill="currentColor" height="24" viewBox="-1.5 -2.5 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12.728 12.728 8.485 8.485l-5.657 5.657 2.122 2.121a3 3 0 0 0 4.242 0l3.536-3.535zM11.284 17H14a1 1 0 0 1 0 2H3a1 1 0 0 1-.133-1.991l-1.453-1.453a2 2 0 0 1 0-2.828L12.728 1.414a2 2 0 0 1 2.828 0L19.8 5.657a2 2 0 0 1 0 2.828L11.284 17z"/></svg>
                        </button>
                        { supported ?
                        <button onMouseDown={voiceSearch} onTouchStart={voiceSearch} onTouchEnd={stop} onMouseUp={stop} className={"w-6 mx-3 "+(listening ? "animate-pulse":null)}>
                            <svg version="1.1" fill="currentColor" viewBox="0 0 16 16" xmlSpace="preserve" xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink"><path d="M8,11c1.657,0,3-1.343,3-3V3c0-1.657-1.343-3-3-3S5,1.343,5,3v5C5,9.657,6.343,11,8,11z"/><path d="M13,8V6h-1l0,1.844c0,1.92-1.282,3.688-3.164,4.071C6.266,12.438,4,10.479,4,8V6H3v2c0,2.414,1.721,4.434,4,4.899V15H5v1h6  v-1H9v-2.101C11.279,12.434,13,10.414,13,8z"/></svg>
                        </button>:null
                        }
                        <CloseButton onClick={ hideSearchBar }/>
                    </div>
                </div>
            )
        }
        </div>
    );
}
