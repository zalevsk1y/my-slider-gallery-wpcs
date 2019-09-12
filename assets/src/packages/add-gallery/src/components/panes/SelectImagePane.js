import React from 'react';
import Pane from '../elements/Pane';
import MediaFrame from '../../containers/MediaFrame';
/**
 * Pane that allow select or upload images with help of Media-Frame. 
 */
export default function SelectImagePane (){
    return (
        <Pane>
           
                <h5>Select or download image</h5>
                <p>You can choose or download images using wordpress media frame.</p>
            
                <MediaFrame />
            
        </Pane>
    )

    
}