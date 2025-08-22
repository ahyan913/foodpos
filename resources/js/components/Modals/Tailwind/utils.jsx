var openEvent = "tailwind.modal.open";
var closeEvent = "tailwind.modal.close";

function show(productId){
    const evt = new CustomEvent(openEvent, { detail:{productId} });
    window.dispatchEvent(evt);
}

export default {
    openEvent,
    closeEvent,
    show
};


