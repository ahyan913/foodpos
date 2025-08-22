import React from 'react';
import "./style.css";


export default function Button({ text, button, container  }){

    var _className = "glowing-effect-button button";

    if(typeof(container) == "object" && Object.keys("className")){
        container.className+=" "+_className;
    }else{
        container = {
            className:_className
        };
    }

    return (
        <div { ...container }>
            <button { ...button }>{text}</button>
        </div>

    );

}
