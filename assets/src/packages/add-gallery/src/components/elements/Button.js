import React from 'react';
import PropTypes from 'prop-types';
/**
 * Button element.
 * 
 * @param {function} onClick Callback to handle click button event.
 * @param {misc} children Child elements or strings.
 * @param {string} className Child elements or strings.
 */
export function Button({onClick,children,className}){
    
    return (

        <button type='button' className={className||''} onClick={onClick}>{children||''}</button>
    )
} 
export default Button;

Button.propTypes={
    onClick:PropTypes.func.isRequired,
}