import React from 'react';
import {Button} from './elements/Button';
import {Select} from './elements/Select';
import PropTypes  from 'prop-types';
/**
 * Like form tag select element with submit button.
 * 
 * @param {number} selected
 * @param {func} onSelect
 */
export class SelectGroup extends React.Component{
    /**
     * Init function.
     * 
     * @param {object} props 
     */
    constructor(props){
        super(props);
        this.selectHandler=this.selectHandler.bind(this);
        this.onChange=this.onChange.bind(this);
        let selected=this.props.selected?this.props.selected:-1;
        this.state={selected}
    }
    /**
     * Change state when new option of select tag selected.
     * 
     * @param {int} id Options of select tag id. 
     */
    onChange(id){
        this.setState({selected:id})
    }
    /**
     * Call onSelect function passed in the props with selected option id as argument. 
     */
    selectHandler(){
       
        this.props.onSelect(this.state.selected)
    }
    render (){
        const selected=this.state.selected!=this.props.selected&&this.state.selected!=-1?this.state.selected:this.props.selected;
        return(
            <div className="input-group mb-3">
                <Select options={this.props.options} onChange={this.onChange} selected={selected} ></Select>
                <Button className='btn btn-primary ml-2' onClick={this.selectHandler}>Get</Button>
            </div>
        )
    }
}


SelectGroup.propTypes={
    selected:PropTypes.number,
    onSelect:PropTypes.func.isRequired,
}