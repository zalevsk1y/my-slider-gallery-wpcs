import React from 'react';
import {Card} from '../elements/Card';



export default function IntroCard(){
    return (
        <Card title="Select Post">
            <p className="card-text">
                To add a modification to the gallery, you need to select a post. 
                If the selected post contains the "my-gallery" shortcode, you can modify it or add a new one. 
                When you generate a shortcode for your gallery, you can add it not only to this post, but to any other.
            </p>
    </Card>
    )
} 