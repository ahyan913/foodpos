import React, { useState, useEffect, useRef } from 'react';

import ReactDOM from 'react-dom/client';
import ProductList from "../Product/List";

import TabContent from '../TabContent/Tailwind';
import Layout from '../Layouts/Default';


import { useProduct } from '../Contexts/Product';

import { useTranslation } from "react-i18next";

export default function Page({ addCartItem }) {

    const [tabContents, setTabContents] = useState({});
    const { t } = useTranslation();
    const { getSearchResults, products, searchText } = useProduct();

    useEffect(()=>{
        const results = getSearchResults();
        setTabContents({
            tabs:[
                { text: t("Eat in / Take away"), attrs:{
                    id:"btn-takeaway"
                }},
                { text: t("Coupons"), attrs:{
                    id:"btn-coupons"
                }},
            ],
            contents:[
                <ProductList
                    products={results}
                    addCartItem={ addCartItem }
                />,
                (
                    <div>
                        { t("No Coupons") }
                    </div>
                )
            ]
        });


    },[products, searchText])


    let onChange = (e) => {
        setText(e.target.value);
    }




    return (
        <div className="w-full">


            <div className="p-3">
                <TabContent
                    tabContent={tabContents}
                />
            </div>


        </div>
    );
}

if (document.getElementById('app')) {
    const Index = ReactDOM.createRoot(document.getElementById("app"));

    Index.render(
        <React.StrictMode>
            <Layout>
                <Page />
            </Layout>
        </React.StrictMode>
    )
}
