import React from 'react';
import {ReactComponent as Edit} from "../../assets/icons/light/Edit.svg";
import {ReactComponent as Voice} from "../../assets/icons/light/Voice.svg";
import DotFlashing from "../common/DotFlashing";

function LastMessage({lastMessage}) {

    const senderName = lastMessage.sender.name.split(' ')[0];

    const imagesLength = lastMessage.content.media ? lastMessage.content.media.filter(e => e.type === "image").length : 0;
    const filesLength = lastMessage.content.media ? lastMessage.content.media.filter(e => e.type === "file").length : 0;

    const item = () => {
        const message = <>
            <span className="small lighten" style={{textTransform: 'capitalize'}}>
                        {senderName}:
                    </span>
            <span className="small">{lastMessage.content.message}</span>
        </>

        const typing = <>
            <span className="small lighten start" style={{gap: 5}}>
                 <Edit className={'typing-icon'}/>
                 <span style={{textTransform: 'capitalize'}}>
                     {lastMessage.isTyping.name}
                 </span> is typing <DotFlashing/>
            </span>
        </>
        const audio = <>
            <span className="small lighten start" style={{gap: 5}}>
                 <Voice className={'audio-icon'}/>
                 Voice message
            </span>
        </>

        const media = <>
            <span className="small lighten start" style={{gap: 8}}>
                 {imagesLength} {imagesLength > 1 ? 'images' : 'image'}
                <span className="dot-separator"/>
                {filesLength} {filesLength > 1 ? 'files' : 'file'}
            </span>
        </>

        switch (true) {
            case (lastMessage.isTyping !== false):
                return typing
            case (lastMessage.content.message !== null):
                return message
            case (lastMessage.content.audio !== null):
                return audio;
            case (lastMessage.content.media !== null):
                return media;
        }
    }


    return (<>
        <span className="message-label">
            {item()}
        </span>
    </>);
}

export default LastMessage;
