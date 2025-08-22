import axios from "axios";

const list = async ()=>{

    try{
        return await axios.get("/api/products");

    }catch(e){
        return null;
    }


};

export default {
    list


};
