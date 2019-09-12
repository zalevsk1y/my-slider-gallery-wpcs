import React from 'react';
import PropTypes  from 'prop-types';
/**
 * Tab menu for vertical oriented Tab Panes. 
 */
export default function VerticalTabsMenu ({tabsList,onClick,ariaName,className}){
    const tabs=tabsList.map((item,key)=>{
        return (
            <li className="nav-item col-3 col-sm-3 col-md-3 col-lg-12 col-lg-12 p-0 align-items-end d-flex " key={key.toString()} data-tab-id={key} >
                <a className={"nav-link w-100 border border-top-0 border-right-0 border-left-0"+(item.active?" active":"")} data-toggle="tab" href="#" data-tab-id={key} role="tab" aria-selected={item.active?"true":"false"} onClick={onClick}>{item.name}</a>
            </li>
        )
    }
    )
    return(
        <ul className={className} data-aria-name={ariaName} role="tablist">
            {tabs}
        </ul>
    )
} 

VerticalTabsMenu.propTypes={
    tabsList:PropTypes.array.isRequired,
    onClick:PropTypes.func.isRequired,
    ariaName:PropTypes.string,
    className:PropTypes.string
}