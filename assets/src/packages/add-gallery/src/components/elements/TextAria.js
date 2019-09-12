import React from 'react';
import {Input} from './Input';
import PropTypes  from 'prop-types';
/**
 * TextAria element
 * 
 * @param {string} value Value for textAria.
 * @param {funct} onBlur Handle blur event for texAria tag.
 */
export class TextAria extends Input{
    constructor(props) {
        super(props);
        this.state = {
            value: props.value || ''
        };
        this.blurHandler=this.blurHandler.bind(this);
        this.handleChange=this.handleChange.bind(this);
    }
    /**
     * Change element state if textaria tag state changed. 
     * 
     * @param {object} event Change event object.
     */
    handleChange  (event)  {
        this.setState({value: event.target.value});
    }
    /**
     * Calls onBlur unc passed in props and pass textaria value and name of property as args.
     */
    blurHandler  ()  {
        this.props.onBlur&&this.props.onBlur(this.state.value,this.props.propName);  
    }
    /**
     * Change state of element if new value has passed in props. 
     * 
     * @param {object} prevProps 
     * @param {object} prevState 
     */
    componentDidUpdate(prevProps, prevState) {
        if (prevState.value === this.state.value && prevProps.value !== this.props.value) {
            this.setState({value: this.props.value})
        }
    }
    render(){
        const className=this.props.className||'';
        return(
        <textarea className={'input-classnames '+className}  onChange={this.handleChange} onBlur={this.blurHandler} value={this.state.value}></textarea>
        )
    }
} 

TextAria.propTypes={
    value:PropTypes.string,
    onBlur:PropTypes.func.isRequired
}
