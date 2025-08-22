export const thumbnailUrl = (path) =>{
    return "/api/images/thumbnails/"+path;
}

export const src = (path) => {
    return "/api/images/src/"+path;
}

export const storeThumbnail = (path) =>{
    return thumbnailUrl("store/"+path);
}


export const bannerSrc = (path) =>{
    return src("banners/"+path);
}
