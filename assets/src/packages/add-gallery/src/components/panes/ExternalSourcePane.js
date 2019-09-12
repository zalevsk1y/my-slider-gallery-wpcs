import React from 'react';
import Pane from '../elements/Pane';
/**
 * Pane for creating gallery from external source. Not implemented in current version.
 */
export default function ExternalSourcePane(){
    return (
        <Pane>
            <h5>Create dynamic galleries.</h5>
            <p>We are plaining to create dynamic instagram galleries in the next version of myGallery.
                Follow us on twitter to do not miss this important update.</p>
            <div className="d-flex">
            <a href="https://www.facebook.com/evgeny.zalevski"><span className='fo fo-facebook'></span></a>
            <a href="https://twitter.com/EvgeniyZ6"><span className='fo fo-twitter ml-3 mr-3'></span></a>
            <a href="https://github.com/zalevsk1y/MyGallery"><span className='fo fo-github'></span></a>
            </div>
        </Pane>
    )
} 