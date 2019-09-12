import React from 'react';
import PropTypes  from 'prop-types';
/**
 * Pane element part of Tab Pane. 
 * 
 * @param {misc} children 
 */
export default function Pane({children}){
    return(
        <div className="tab-pane fade show active" role="tabpanel" >{children}</div>
    )
}

Pane.propTypes={
    children:PropTypes.any
}