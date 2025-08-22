import React from "react";
import { useTranslation } from "react-i18next";
import CartItem from "./Item";
import { useCart } from "../../Contexts/Cart";
import PrimaryButton from "../../Buttons/Default/PrimaryButton";
import ButtonPanel from "./ButtonPanel";

export default function Step1({ goStep }){

    const { t } = useTranslation();
    const { getItems, getCount } = useCart();

    return (
        <>
            <div className="sticky top-0 left-0 shadow bg-white">
                <div className="grid grid-cols-10 p-3 text-xs ">
                    <div className="col-span-2">
                        <h3 className="font-bold w-[60px]">{t("Image")}</h3>
                    </div>
                    <div className="col-span-4">
                        <h3 className="font-bold">{t("Product")}</h3>
                    </div>
                    <div className="col-span-1 ">
                        <h3 className="font-bold ">{t("Qty")}</h3>
                    </div>
                    <div className="col-span-2 pl-1">
                        <h3 className="font-bold ">{t("Total")}</h3>
                    </div>
                    <div>

                    </div>
                </div>
            </div>
            <div className="store-list " >
                <div className="h-[80vh] max-h-[80vh] overflow-y-auto pb-20 flex flex-col gap-1">
                    { getItems().map((cartItem, i) => {
                        return <CartItem key={"cart-item-"+i } cartItem={cartItem}  />
                    })}
                </div>

                <ButtonPanel className="justify-center">
                    <PrimaryButton className="p-3" onClick={()=>{goStep(2)} } >{ t("Next: Select Payment Method") }</PrimaryButton>
                </ButtonPanel>
            </div>
        </>
    );

}
