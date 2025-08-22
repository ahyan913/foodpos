import React from 'react';
import "react-responsive-carousel/lib/styles/carousel.min.css";
import { Carousel } from 'react-responsive-carousel';

export default function Default({ carousels }){

    const _carousels = carousels ?? [];

    if(!_carousels.length)
        return null;

    var Image = ({src}) => {

        return (
            <img src={src}  alt="Image" />
        )
    }

    var ImageLink = ({a, src}) => {

        return (
            <a {...a}>
                <Image src={src} alt="Image" />
            </a>
        );
    }


    return (
        //
        <Carousel
            showThumbs={false}
            showStatus={false}
            infiniteLoop={true}
            autoPlay={true}
            showArrows={false}
            interval={3000}
        >
            {
            carousels.map((carousel, index) => {
                return (
                    <div key={ "carousel-"+index } className="flex items-center bg-gray-400 h-full">
                        <Image {...carousel} />
                    </div>
                )
            })
            }
        </Carousel>
    )



}
