import React from 'react';

function ButtonClassic(props) {
    return (
        <div onClick={props.onClick} className="button">
            <span className="wp-media-buttons-icon dashicons-my-gallery"></span>
            Add My Slider Gallery
        </div >
    )
}

export default ButtonClassic;