import React from 'react';
import SortableImageList from './elements/SortableImageList';
import PropTypes  from 'prop-types';
/**
 * Container for sortable list elements.
 */
export default class GallerySortable extends React.Component{
  /**
   * Init function.
   * 
   * @param {object} props 
   */
    constructor(props){
        super(props);
     
        this.onSortEnd=this.onSortEnd.bind(this);
    }
  
    onSortEnd ({oldIndex, newIndex}) {
  
        this.props.onChange&&this.props.onChange({oldIndex, newIndex})
      };
      render() {
        return <SortableImageList axis="xy" items={this.props.items} onSortEnd={this.onSortEnd} />;
      }
}

GallerySortable.propTypes={
    items:PropTypes.node
}