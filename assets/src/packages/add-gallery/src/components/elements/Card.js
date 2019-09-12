import React from 'react';
import PropTypes from 'prop-types';
/**
 * Base Card element.
 * 
 * @param {string} className ClassName.
 * @param {object} style CSS style of Card container.
 * @param {string} id Id identifier of Card element.
 * @param {misc} children Cards body.
 * 
 */
export function Card({className,style,title,id,children}){
        return(
            <div className={"my-gallery-card mb-3 "+(className||'')} style={style} id={id}>
                <div className="card-body">
                    <h5 className="card-title">{title}</h5>
                    
                    {children}
                   
                    </div>  
            </div>
        )
    }

Card.propTypes={
    className:PropTypes.string,
    style:PropTypes.object,
    id:PropTypes.string,
    children:PropTypes.any
}