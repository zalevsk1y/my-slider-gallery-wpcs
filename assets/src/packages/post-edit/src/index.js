import {myGalleryGutenberg} from './buttonController';
import {myGalleryClassic} from './buttonController';
import {getEditorType} from '@my-gallery/helpers';
import {myGalleryPlugin} from 'globals';


if(!myGalleryPlugin){
   myGalleryPlugin=window.myGalleryPlugin={}
}
export const myGalleryGlobalConfig = myGalleryPlugin;
export {myGalleryClassic} from './buttonController';
export {myGalleryGutenberg} from './buttonController';


window.addEventListener('DOMContentLoaded', ()=>{
    myGalleryGlobalConfig.editor = getEditorType();
    switch (myGalleryGlobalConfig.editor) {
        case 'gutenberg':
            myGalleryGutenberg();
            break;
        case 'classic':
            myGalleryClassic();
            break;
    }
} )
