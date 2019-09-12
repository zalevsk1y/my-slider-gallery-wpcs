import {myGalleryClassic,myGalleryGutenberg} from "@my-gallery/post-edit";
import {getEditorType} from '@my-gallery/helpers';
import {myGalleryPlugin} from 'globals';

if(!myGalleryPlugin){
    myGalleryPlugin=window.myGalleryPlugin={}   
 }
 export const myGalleryGlobalConfig = myGalleryPlugin;
window.addEventListener('load', ()=>{
    myGalleryGlobalConfig.editor = getEditorType();
    switch (myGalleryGlobalConfig.editor) {
        case 'classic':
            myGalleryClassic();
            break;
        case 'gutenberg':
            myGalleryGutenberg();
            break;
    }
});