import React from 'react';
import style from './style.css';

export default function TabContent({container, tabContent }){

    const {useState, useEffect} = React;
    const [activeIndex, setActiveIndex] = useState(0);
    //const [content, setContent] = useState();

    const {contents, tabs} = tabContent;

    var content = null;
    try{
        content = contents[activeIndex];
    }catch{
        content = null;
    }

    var switchTab = (e => {
        const index = e.target.getAttribute("data-tab");
        setActiveIndex(index);
    });

    return Object.keys(tabContent).length > 0 ? (
        <div className="tab-content "  {...container}>
            <nav className="tab-nav mb-6 flex-nowrap flex overflow-y-hidden max-w-full sticky top-0 bg-white dark:bg-slate-700">
                { tabs.map((tab, index)=>{
                const { attrs, text } = tab
                return (
                    <a key={"tab-link-"+index } {...attrs} className={"whitespace-nowrap p-3 cursor-pointer "+(activeIndex == index ? "border-b-4 border-gray-200":"") } data-tab={index} onClick={switchTab}>{text}</a>
                )
                })}
            </nav>
            <div className="content">{content}</div>
        </div>
    ):null;
}
