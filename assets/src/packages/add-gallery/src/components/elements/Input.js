import React from 'react';
import PropTypes  from 'prop-types';
/**
 * Input element.
 * 
 * @param {string} value Value that will be set to the input.
 * @param {func} onBlur Function that handles blur event of input tag. 
     
 }} 
 */
export class Input extends React.Component {
    /**
     * Init function.
     * 
     * @param {object} props 
     */
    constructor(props) {
        super(props);
        this.state = {
            value: props.value || ''
        };
        this.blurHandler=this.blurHandler.bind(this);
        this.handleChange=this.handleChange.bind(this);
    }
    /**
     * Update state of Input element as input tag state was changed. 
     * 
     * @param {object} event Change event object.
     */
    handleChange  (event)  {
        this.setState({value: event.target.value});
    }
    blurHandler  ()  {
        this.props.onBlur&&this.props.onBlur(this.state.value,this.props.propName);  
    }
    /**
     * Lifecycle method. Update state if new value get from props.   
     * 
     * @param {misc} prevProps 
     * @param {misc} prevState 
     */
    componentDidUpdate(prevProps, prevState) {
        if (prevState.value === this.state.value && prevProps.value !== this.props.value) {
            this.setState({value: this.props.value})
        }
    }
    render() {
        const className=this.props.className||'';
        return (
        
            <input className={'input-title '+className} value={this.state.value} onChange={this.handleChange} onBlur={this.blurHandler} />)
    }
}

export default Input

Input.propTypes={
    value:PropTypes.string,
    onBlur:PropTypes.func.isRequired
}





