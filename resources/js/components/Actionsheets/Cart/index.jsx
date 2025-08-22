import React, { forwardRef, useEffect, useState } from "react";
import {useTranslation} from 'react-i18next';
import ActionSheet from 'actionsheet-react';
import Step1 from "./Step1";
import Step2 from "./Step2";
import Step3 from "./Step3";
import CloseButton from "../../Buttons/Default/CloseButton";
import { useCart } from "../../Contexts/Cart";

export default forwardRef(function CartActionSheet(props, ref) {

    const { t } = useTranslation();
    const [ step, setStep ] = useState(1);
    const [ paymentMethod, setPaymentMethod ] = useState("");
    const { getGrandTotal, hideSheet } = useCart();

    const close = ()=>{
        hideSheet();
        goStep(1);
    }

    const placeOrder = ()=>{
        alert(t("Coming Soon"));
        close();
    }

    const goStep = (step) => {
        setStep(step);

    }

    const Steps = () => {

        switch(step){
            case 2:
                return (<Step2
                    setPaymentMethod={setPaymentMethod}
                    goStep={goStep}
                />);
            case 3:
                return (<Step3
                    placeOrder={placeOrder}
                    goStep={goStep}
                    paymentMethod={paymentMethod}
                />);
            default:
                return (
                <Step1
                    goStep={goStep}
                />);
        }

    }

    const StepHeader = () =>{

        var title = t("Step 1: Check cart items");
        switch(step){
            case 2:
                title = t("Step 2: Select payment method")
                break;
            case 3:
                title = t("Step 3: Confirm order")
                break;
            default:
                break;
        }

        return (
            <h2>{ title }</h2>
        )

    }

    return (
        <ActionSheet
            ref={ref}
            sheetTransition="transform 0.5s ease-in-out"
            touchEnable={false}
        >
            <div className="sticky justify-end top-0 shadow p-4 bg-white dark:bg-slate-800 ">
                <div className="flex justify-between mb-2 items-center">
                    <h2 className="text-xl">{t("Cart")} <span>{t("Total:")}HKD: ${getGrandTotal().toFixed(2)}</span></h2>
                    <CloseButton onClick={close}></CloseButton>
                </div>
                <StepHeader />
            </div>
            <div className="p-3 relative dark:bg-slate-800">
                <Steps />
            </div>
        </ActionSheet>
    );
});
