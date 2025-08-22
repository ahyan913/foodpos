<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width:device-width, initial-scale=1.0" />
        <meta name="description" content="">

        <script src="//cdn.tailwindcss.com"></script>
        <link href="//cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
        <script src="/js/tailwind.config.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
        <script src="//code.jquery.com/jquery-3.6.0.js"></script>
        <script src="//code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    </head>
    <body>

        <ul class="list">
            <li class="item">Item</li>
            <li class="item">Item</li>
            <li class="item">Item</li>
            <li class="item">Item</li>
            <li class="item">Item</li>
            <li class="item">Item</li>
            <li class="item">Item</li>
            <li class="item">Item</li>
            <li class="item">Item</li>
            <li class="item">Item</li>
        </ul>

        <script>
            var lastElement = document.querySelector(".item:last-child");

            var intersectObserver = new IntersectionObserver(entries=>{

                entries.forEach(entry=>{
                    console.log(entry);
                    entry.target.classList.toggle("show",entry.isIntersecting);
                    // if(entry.isIntersecting)
                    //     intersectObserver.unobserve(entry.target);
                });


            }, {
                threshold: 1
                //rootMargin: '100px'
            });
            const items = document.querySelectorAll(".item");
            items.forEach(item => {
                intersectObserver.observe(item);
            });


            var lastItemObserver = new IntersectionObserver(entries=>{
                const lastItem = entries[0];

                if(!lastItem.isIntersecting) return



                const list = document.querySelector(".list");
                for(var i=0; i<10;i++){

                    var elem = document.createElement("li")
                    elem.classList.add("item");
                    elem.textContent = "New Item";
                    intersectObserver.observe(elem);
                    list.append(elem);

                }

                lastItemObserver.unobserve(lastItem.target);
                lastItemObserver.observe( document.querySelector(".item:last-child"));

            },{
                rootMargin:"100px"

            });

            lastItemObserver.observe(lastElement);

        </script>
        <style type="text/css" rel="stylesheet">
            .list{
                display:flex;
                gap:1rem;
                align-items: flex-start;
                flex-direction: column;
            }
            .item{
                background-color:skyblue;
                transition-duration: 1s;
                transform: scale(0.5);
                padding: 1.5em;
                opacity: 0;
            }
            .item.show{
                transform: scale(1);
                opacity: 1;

                /* transition-delay: 0.05s; */
                background-color: orange;
            }
        </style>


    </body>
</html>
