import React, {createContext, useContext, useState, useEffect} from "react";
import { getCookie, setCookie } from "../../utils/Cookie";

const DarkmodeContext = createContext(null);
const UpdateDarkmodeContext = createContext(null);


export function useDarkmode(){
    return useContext(DarkmodeContext);
}

export function useUpdateDarkmode(){
    return useContext(UpdateDarkmodeContext);
}

export default function DarkmodeContextProvider({children}){

    const [isDarkmode, setIsDarkmode] = useState(false);
    useEffect(()=>{
        const darkmode = getCookie("darkmode") == "true";
        setIsDarkmode(current=>{
            updateDarkmode(darkmode);
            return darkmode
        });

    }, []);

    const updateDarkmode = (darkmode) => {
        setCookie("darkmode", darkmode, 1);
        const bodyClass = document.querySelector("body").classList;
        if(darkmode){
            bodyClass.add("dark");
        }else{
            bodyClass.remove("dark");
        }

    }

    const toggleDarkmode = () =>{
        setIsDarkmode(current=>{
            updateDarkmode(!current);
            return !current
        });
    }

    return (
        <DarkmodeContext.Provider value={isDarkmode}>
            <UpdateDarkmodeContext.Provider value={toggleDarkmode}>
            {children}
            </UpdateDarkmodeContext.Provider>
        </DarkmodeContext.Provider>
    );

}
