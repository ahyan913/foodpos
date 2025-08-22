import React, { useState, useEffect } from "react";
import { useTranslation } from "react-i18next";
import PrimaryButton from "../../Buttons/Default/PrimaryButton";
import ButtonPanel from "./ButtonPanel";

export default function Step2({ goStep,  setPaymentMethod }){

    const { t } = useTranslation();
    const [ selectedMethod, setSelectedMethod ] = useState("");

    const paymentMethods = [
        {
            method: "payme",
            label: t("Payme"),
            image: "https://play-lh.googleusercontent.com/u18c1G3zGn92RIwU-NERrLBoLb2jcH_AeIjajZrjyK6ubm-D5t6ZLozIheQDhj6B5XDv=w240-h480-rw"
        },
        {
            method: "alipayhk",
            label: t("Alipay"),
            image: "https://play-lh.googleusercontent.com/FiSDwTydYXCeuNice6bZKInGGuKA44fPSZSLT3OjpafPHDMaAmG2SO-kFY_l5rXDWlbx"
        },
        {
            method: "wechatpay",
            label: t("Wechat Pay"),
            image: "https://st.moneydata.hk/res/mojo_static/72a34d94668f7407912647232444279f.png",
        },
        {
            method: "octopus",
            label: t("Octopus"),
            image: "https://play-lh.googleusercontent.com/YP6kKx15IquoSUOWlNj-8-cRG4KJnqtefkdP_XdHy8FSjhdYGpuvPVsJmvlE4JQKeCk"
        },
        {
            method: "creditcard",
            label: t("Visa/Master"),
            image: "https://e7.pngegg.com/pngimages/363/177/png-clipart-visa-mastercard-logo-visa-mastercard-computer-icons-visa-text-payment.png"
        }
    ];

    const updatePaymentMethod = ()=>{
        if(Object.keys(selectedMethod).length > 0){
            setPaymentMethod(selectedMethod);
            goStep(3);
        }else{
            alert(t("Please select payment method"))
        }
    };

    const selectPaymentMethod = (method) => {
        setSelectedMethod(method)
    }

    const prev = () => {
        goStep(1);
    }

    return (
        <>
            <div className="store-list " >
                <div className="h-[80vh] max-h-[80vh] overflow-y-auto pb-20 flex flex-col gap-1">
                    <div className="payment-methods gap-3 grid grid-cols-3">
                        {
                        paymentMethods.map((_paymentMethod)=>{
                            const {method, label, image} = _paymentMethod;
                            return (
                                <a  key={method}
                                    onClick={()=>{ selectPaymentMethod(_paymentMethod) }}
                                    className={"cursor-pointer inline-flex flex-col gap-1 justify-center items-center p-2 rounded "+( method == selectedMethod.method ? "bg-gray-200  dark:bg-slate-900":"")}
                                >
                                    <img src={image} alt={label} className="basis-1 rounded w-[50px] h-[50px]" width="50" height="50" />
                                    <span className="text-sm basis-4">{ label }</span>
                                </a>
                            );
                        })
                        }
                    </div>
                </div>
                <ButtonPanel className="justify-between">
                    <PrimaryButton className="p-3" onClick={prev} >{ t("Back: Check cart items") }</PrimaryButton>
                    <PrimaryButton className="p-3" onClick={updatePaymentMethod} >{ t("Next: Confirm order") }</PrimaryButton>
                </ButtonPanel>
            </div>
        </>
    );

}
