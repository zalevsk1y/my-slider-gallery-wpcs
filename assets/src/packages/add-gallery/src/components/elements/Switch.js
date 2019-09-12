import React from 'react';
import PropTypes  from 'prop-types';
/**
 * Switch element.
 * 
 * @param {bool} state State of switch.
 * @param {func} onChange Handle click on switch.
 */
export class Switch extends React.Component{
    /**
     * Init function.
     * 
     * @param {object} props 
     */
    constructor(props){
        super(props);

        this.onClick=this.onClick.bind(this)
    }
    /**
     * Calls onChange func that pass in props and pass current switch state and switch param name as args.
     */
    onClick(){
        this.props.onChange(!this.props.state,this.props.propName);
    }
    render(){
        return(
            <div className="switch" onClick={this.onClick}>
                <label>
                <span className={"lever"+(this.props.state?" on":"")}></span>
                </label>
            </div>
        )
    }
}

Switch.propTypes={
    state:PropTypes.bool,
    onChange:PropTypes.func.isRequired
}