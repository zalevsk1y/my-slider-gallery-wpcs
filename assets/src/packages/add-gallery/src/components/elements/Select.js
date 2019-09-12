import React from 'react';
import PropTypes  from 'prop-types';
/**
 * Select list element.
 * 
 * @param {array} options Select options array.
 * @param {number} selected Index of selected option.
 * @param {func} onChange Function that handle change of selected option.
 */
export class Select extends React.Component{
    /**
     * Init function.
     * 
     * @param {object} props 
     */
    constructor(props){
        super(props);
        this.options=this.options.bind(this);
        this.onChange=this.onChange.bind(this);
    }
    /**
     * Calls function onChange that was passed in props end
     * pass index of selected option and option name as arguments.
     * 
     * @param {object} event Click object event. 
     */
    onChange(event){    
        this.props.onChange(event.currentTarget.selectedOptions[0].value,this.props.propName)
    }
    /**
     * Renders options that was passed in props as array.
     * 
     * @returns {nodes} Returns array of nodes or empty array.
     */
    options(){
        const optionsArray=this.props.options?this.props.options.map((item,key)=>{
         
            return (
                <option value={item.id} key={key.toString()}>{item.title}</option>
            )
        }):[];
       
        return optionsArray;
    }
    render(){
        const className=this.props.className?this.props.className:'';
        const selected=this.props.selected;
        return (
            <select className={"custom-select pl-3 "+className} onChange={this.onChange} value={selected} >
                <this.options></this.options>
            </select>
        )
    }
}

Select.propTypes={
    options:PropTypes.array,
    selected:PropTypes.number,
    onChange:PropTypes.func.isRequired
}
