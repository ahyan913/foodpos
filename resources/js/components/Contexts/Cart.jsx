import React, { createContext, useState, useContext, useRef, useMemo, useCallback } from "react";
import ActionSheet from "../Actionsheets/Cart";
import { useTranslation } from "react-i18next";
import ProductOptionModal from "../Modals/ProductOptionModal";


const CartContext = createContext(null);
const ProductOptionsModalContext = createContext(null);

export function useCart(){
    return useContext(CartContext);
}

export function CartContextProvider({children}){

    const [cartItems, setCartItems] = useState([]);
    const {t} = useTranslation();
    const ref = useRef();
    const [isProductOptionsModalShown, setIsProductOptionsModalShown] = useState(false);
    const [ productInModal, setProductInModal ] = useState([]);
    const [ selectedProductOptions, setSelectedProductOptions ] = useState([]);


    const clearSelectedProductOptions = ()=>{
        setSelectedProductOptions(prev => [...[]]);
    }

    const getSelectedProductsGrandTotal = function(price){
        selectedProductOptions.forEach(optionGroup=>{
            optionGroup.options.forEach(option=>{
                if(option.price > 0){
                    price = parseFloat(price) + parseFloat(option.price) * (option.qty) ;
                }

                if(option?.product){
                    option?.product.option_groups.forEach(_productOptionGroup => {
                        _productOptionGroup.options.forEach(_productOptionGroupOption => {
                            if(_productOptionGroupOption?.qty){
                                price = parseFloat(price) + parseFloat(_productOptionGroupOption.price) * (_productOptionGroupOption.qty);
                            }
                        });
                    });
                }
            });
        });
        return parseFloat(price);
    }

    const updateSelectedProductOptions = (optionGroup, option, qty, clearAndAdd)=>{
        var updated = false;
        setSelectedProductOptions(_selectedOption => {
            if(!updated){
                updated = true;
                var groupIndex = _selectedOption.findIndex(item=>(item.id === optionGroup.id));
                if(qty < 0){
                    if(groupIndex >= 0){
                        //console.log("-1");
                        var optionIndex = _selectedOption[groupIndex].options.findIndex(item=>item.id === option.id);
                        if(optionIndex >= 0){
                            if(_selectedOption[groupIndex].options[optionIndex].qty + qty == 0){
                                //console.log("-3");
                                _selectedOption[groupIndex].options = _selectedOption[groupIndex].options.filter(_option=>(option.id != _option.id));
                                return [..._selectedOption];
                            }else{
                                //console.log("-4");
                                _selectedOption[groupIndex].options[optionIndex].qty += qty;
                            }
                            //console.log(_selectedOption);
                        }
                    }
                }else{
                    if(groupIndex >= 0){
                        if(clearAndAdd){
                            console.log("Before",_selectedOption);
                            option.qty = qty;
                            _selectedOption[groupIndex].options = [option];
                            console.log("After",_selectedOption);
                        }else{
                            var optionIndex = _selectedOption[groupIndex].options.findIndex(item=>item.id === option.id);
                            if(optionIndex >= 0){
                                _selectedOption[groupIndex].options[optionIndex].qty += qty;
                            }else{
                                option.qty = qty;
                                _selectedOption[groupIndex].options.push(option);
                            }
                        }
                    }else{
                        option.qty = qty;
                        _selectedOption.push({...optionGroup, ...{"options":[option]}});
                        //console.log(_selectedOption);
                    }
                }

                try{
                    // }
                    return [..._selectedOption];
                }catch(e){
                    //console.error(_selectedOption);
                }
            }
            return _selectedOption;
        });
    }

    const updateSelectedProductSubOptions = (_parentOptionGroupId, _parentOptionId, productId, optionGroup, option, qty, clearAndAdd)=>{
        // TODO: update sub product option to current selected option
        //const result = selectedProductOptions.find(optionGroup=> optionGroup.options.find(option => option?.product.id === productId));
        //console.log(result);
        var parentOptionGroupIndex = null;
        var parentOptionIndex = null;
        var productOptionGroupIndex = null;
        var productOptionGroupOptionIndex = null;
        selectedProductOptions.forEach((_parentOptionGroup, _index1) => {
            if(_parentOptionGroup.id === _parentOptionGroupId){
                _parentOptionGroup.options.forEach((_parentOption, _index2) => {
                    if(_parentOption.id === _parentOptionId && _parentOption?.product?.id == productId){
                        _parentOption.product.option_groups.forEach((productOptionGroup, _index3) => {
                            if(productOptionGroup.id === optionGroup.id){
                                productOptionGroup.options.forEach((productOptionGroupOption, _index4)=>{
                                    if(clearAndAdd){
                                        delete selectedProductOptions[_index1].options[_index2].product.option_groups[_index3].options[_index4].qty;
                                    }
                                    if(productOptionGroupOption.id === option.id){
                                        parentOptionGroupIndex = _index1;
                                        parentOptionIndex = _index2;
                                        productOptionGroupIndex = _index3;
                                        productOptionGroupOptionIndex = _index4;
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });

        if(productOptionGroupOptionIndex != null){
            console.log(selectedProductOptions);
            var _qty = selectedProductOptions[parentOptionGroupIndex]
                    .options[parentOptionIndex]
                    .product.option_groups[productOptionGroupIndex]
                    .options[productOptionGroupOptionIndex]?.qty

            if( qty > 0 ){

                if(_qty){
                    _qty += qty;
                    console.log("r1");
                }else{
                    _qty = 1;
                    console.log("r2");
                }

                selectedProductOptions[parentOptionGroupIndex]
                    .options[parentOptionIndex]
                    .product.option_groups[productOptionGroupIndex]
                    .options[productOptionGroupOptionIndex].qty = _qty

            }else{

                if(_qty + qty > 0){
                    selectedProductOptions[parentOptionGroupIndex]
                    .options[parentOptionIndex]
                    .product.option_groups[productOptionGroupIndex]
                    .options[productOptionGroupOptionIndex].qty = (_qty + qty);

                }else{
                    delete selectedProductOptions[parentOptionGroupIndex]
                    .options[parentOptionIndex]
                    .product.option_groups[productOptionGroupIndex]
                    .options[productOptionGroupOptionIndex].qty;
                }
            }
        }

        setSelectedProductOptions(prev=>([...selectedProductOptions]));
    }

    const checkout = () => {
        if(getCount() > 0){
            showSheet();
        }else{
            alert(t("Please select at least one item"));
        }
    }

    const getGrandTotal = () => {
        let grandTotal = 0;
        cartItems.forEach(item=>(grandTotal+=item.product.price*item.qty));
        return grandTotal ? grandTotal : 0;
    }

    const getCount = ()=>{
        return cartItems.length;
    }

    const addToCart = (product)=>{
        if(product.option_groups.length == 0){
            addItem({...product, ...{selectedOptions:[]}}, 1);
        }else{
            showProductOptionsModal(product);
        }

    }

    const decrementItem = (item =>{
        var updated = false;
        setCartItems(items=>{
            if(!updated){
                updated = true;
                return updateItemQty(items, item, -1);
            }else{
                return items;
            }
        });
    });

    const getTotalItemsQty = function(){

        var total = 0;
        cartItems.forEach((item)=>{
            total+=item.qty;
        });
        return total;
    }

    const addItem = (item, qty) => {
        var updated = false;
        setCartItems(items=> {
            if(!updated){
                updated = true;
                return updateItemQty(items, item, qty)
            }else{
                return items;
            }
        });
    }

    const removeItem = (product) => {
        setCartItems(current => {
            var result = current.filter(item => item.product.id != product.id);
            if(result.length == 0){
                hideSheet();
            }
            return [...result];
        });
        //setCartItems((current)=> [...current.splice(index, 1)]);

    }

    const updateItemQty = (items, product, qty) => {
        // var result =  items.find(_item => _item.product.id === product.id);
        // if(result){
        //     result.qty += qty;
        //     return [...items];
        // }
        return [...items, { product, qty}];
    }

    const incrementItem = (item =>{
        var updated = false;
        setCartItems(items=>{
            if(!updated){
                updated = true;
                return updateItemQty(items, item, 1);
            }else{
                return items;
            }
        });
    });

    const getItems = ()=>{
        return cartItems;
    }

    const showSheet = ()=>{
        ref.current.open();
    }

    const hideSheet = ()=>{
        ref.current.close();
    }

    const showProductOptionsModal = (product) => {
        setProductInModal(product);
        setIsProductOptionsModalShown(true);
    }

    const closeProductOptionsModal = () => {
        setProductInModal(null);
        setIsProductOptionsModalShown(false);
    }

    var functions = {
        incrementItem,
        decrementItem,
        removeItem,
        addItem,
        getItems,
        getTotalItemsQty,
        getGrandTotal,
        getCount,
        showSheet,
        hideSheet,
        checkout,
        showProductOptionsModal,
        closeProductOptionsModal,
        addToCart,

        selectedProductOptions,
        getSelectedProductsGrandTotal,
        updateSelectedProductOptions,
        updateSelectedProductSubOptions,
        clearSelectedProductOptions
    };

    return (
        <CartContext.Provider value={functions}>

            {children}
            <ActionSheet ref={ref} />
            {
                isProductOptionsModalShown ?
                <ProductOptionModal
                    product={productInModal}
                    close={closeProductOptionsModal}
                />:null
            }

        </CartContext.Provider>
    );

}
