import React, { useState } from "react";
import { useTranslation } from "react-i18next";
import CartItem from "./Item";
import { useCart } from "../../Contexts/Cart";
import PrimaryButton from "../../Buttons/Default/PrimaryButton";
import ButtonPanel from "./ButtonPanel";

export default function Step3({ goStep, placeOrder, paymentMethod }){

    const { t } = useTranslation();
    const { getItems, getCount } = useCart();

    const prev = ()=>{
        goStep(2);
    }

    return (
        <>
            <div className="p-1 h-[80vh] max-h-[80vh] overflow-y-auto text-sm" >
                { getCount() ?
                    <div className=" pb-20 flex flex-col gap-1">
                        <h2 className="border-solid border-b-2 pb-3 border-gray-300">{ t("Selected Items") }</h2>
                        <div className="relative">
                            <div className="sticky top-0 left-0 shadow bg-white">
                                <div className="grid grid-cols-10 text-xs">
                                    <div className="col-span-2">
                                        <h3 className="font-bold p-3 w-[60px]">{t("Image")}</h3>
                                    </div>
                                    <div className="col-span-4">
                                        <h3 className="font-bold py-3">{t("Product")}</h3>
                                    </div>
                                    <div className="col-span-1">
                                        <h3 className="font-bold py-3">{t("Qty")}</h3>
                                    </div>
                                    <div className="col-span-2">
                                        <h3 className="font-bold py-3">{t("Total")}</h3>
                                    </div>
                                </div>
                            </div>
                            <div className="mb-3 flex flex-col gap-1">
                                { getItems().map((cartItem, i) => {
                                    return <CartItem key={"cart-item-"+i } cartItem={cartItem} />
                                })}
                            </div>
                        </div>
                        <hr className="my-6" />
                        <div className="payment-method gap-3 flex flex-col ">
                            <h2 className="border-solid border-b-2 border-gray-300 pb-3">{ t("Selected Payment Method") }</h2>
                            <div className="flex gap-3 items-center">
                                <img src={paymentMethod.image} alt={paymentMethod.label} width="60" height="60" />
                                <span>{ paymentMethod.label }</span>
                            </div>
                        </div>
                    </div>
                    : t("Cart is empty")
                }
                <ButtonPanel className="justify-between">
                    <PrimaryButton className="p-3" onClick={ prev } >{ t("Back: Select payment method") }</PrimaryButton>
                    <PrimaryButton className="p-3" onClick={placeOrder} >{ t("Confirm place order") }</PrimaryButton>
                </ButtonPanel>
            </div>
        </>
    );
}
