import React, {useState, useRef, lazy } from 'react';
import Menu from '../../Menus/Bottom';
import DarkmodeContextProvider from '../../Contexts/Darkmode';
import LocaleContextProvider from '../../Contexts/Locale';
import { CartContextProvider } from '../../Contexts/Cart';
import { ProductContextProvider } from '../../Contexts/Product';
import FlowbiteCarousel from "../../Carousels/Flowbite";
import { bannerSrc } from '../../../utils/Url';

const StoreActionSheet = lazy(() => import("../../Actionsheets/Store"));
const LocaleActionSheet = lazy(() => import("../../Actionsheets/Locale"));
const MainMenu = lazy(()=> import('../../Sidebars/MainMenu'));
const CartActionSheet = lazy(()=>import('../../Actionsheets/Cart'));
const Modal = lazy(()=>import('../../Modals/Tailwind'));



export default function Layout({children}){

    const [cartItems, setCartItems] = useState([]);

    const [isOpen, setIsOpen] = useState(false);

    const toggleDrawer = () =>{
        setIsOpen((prevState) => !prevState)
    };

    const ref = useRef();
    const localeRef = useRef();
    const cartRef = useRef();

    const openStoreMenu = ()=>{
        ref.current.open();
    }

    const openLocaleMenu = ()=>{
        localeRef.current.open();
    }

    const openMainmenu = ()=>{
        setIsOpen(true);
    }

    const carousels = [
        {
            a:{
                href: "#",
            },
            src:bannerSrc("sample1.jpg")
        },
        {
            a:{
                href: "#",
            },
            src: bannerSrc("sample2.jpg")
        },
        {
            a:{
                href: "#",
            },
            src: bannerSrc("sample3.jpg")
        }
    ];

    //children.setCartItem = setCartItem;
    return (
        <>
            <FlowbiteCarousel
                carousels={carousels}
            />
            <DarkmodeContextProvider>
                <LocaleContextProvider>
                    <CartContextProvider>
                        <ProductContextProvider>
                        {children}
                        <Menu
                            openLocaleMenu={openLocaleMenu}
                            openMainmenu={openMainmenu}
                        />
                        <Modal />
                        <StoreActionSheet
                            ref={ref}
                        />
                        <LocaleActionSheet
                            ref={localeRef}
                        />



                        {/* <Sidebar
                            ref={sidebarRef}
                            openStoreMenu={openStoreMenu}
                        /> */}

                        <MainMenu
                            isOpen={isOpen}
                            setIsOpen={toggleDrawer}
                            openStoreMenu={openStoreMenu}
                        />
                        </ProductContextProvider>
                    </CartContextProvider>
                </LocaleContextProvider>
            </DarkmodeContextProvider>
        </>
    )
}
