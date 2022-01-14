import React, {useState} from 'react';
import clsx from "clsx";
import Avatar from "../common/Avatar";
import {ReactComponent as SoundWave} from '../../assets/svg/sound-wave.svg';
import {ReactComponent as PlayIcon} from '../../assets/icons/bold/chevron-right.svg';
import {ReactComponent as Volume} from '../../assets/icons/bold/Volume.svg';
import TimeCode from "../common/TimeCode";

function Message({sent, received, content, user, oldMessage}) {
    const [playing, setPlaying] = useState(true);
    const isSameSender = oldMessage ? oldMessage.sender.id === user.id : false;

    const message = <>
        <div className={clsx('message', sent ? 'sent' : null, received ? 'received' : null)}
             style={{
                 margin: isSameSender ? '5px 0' : null,
                 borderRadius: isSameSender ? 25 : null,
                 left: isSameSender ? 50 : null
             }}>
            {content.message}
        </div>
    </>


    const audio = <>
        <div className={clsx('message space-between', sent ? 'sent' : null, received ? 'received' : null)}
             style={{
                 margin: isSameSender ? '5px 0' : null,
                 borderRadius: isSameSender ? 25 : null,
                 paddingTop: 0,
                 paddingBottom: 0,
                 left: isSameSender ? 50 : null
             }}>

            {!playing && <PlayIcon className={'play-icon fill-white icon-clickable'} onClick={() => setPlaying(true)}/>}
            {playing && <Volume style={{width: 20, marginRight: 7, marginLeft: 6}} className={'fill-white icon-clickable'} onClick={() => setPlaying(false)}/>}
            <SoundWave className={'sound-wave'}/>
            <TimeCode time={0.13}/>
        </div>
    </>

    const images = <>
        <div className={clsx('message-image', sent ? 'sent' : null, received ? 'received' : null)}
             style={{
                 margin: isSameSender ? '5px 0' : null,
                 left: isSameSender ? 50 : null
             }}>
            {content.media ? content.media.map((media, index) => {
                return <img key={index} src={media.url} alt={index}/>
            }) : null}
        </div>
    </>


    const item = () => {
        switch (true) {
            case (content.message !== null):
                return message
            case (content.audio !== null):
                return audio;
            case (content.media !== null):
                return images;
        }
    }

    return (<>
        <div className="message-container"
             style={{
                 flexDirection: sent ? 'row-reverse' : null,
                 marginTop: isSameSender ? 0 : 16
             }}>
            {!isSameSender && <Avatar image={user.image} user={user} size={32}/>}
            <div>
                {!isSameSender &&
                    <div className="start" style={sent ? {justifyContent: 'flex-end', gap: 10} : {gap: 10}}>
                        <span className="message-sender">{user.name}</span>
                        <span className="message-time">4m</span>
                    </div>}
                {item()}
            </div>
        </div>
    </>);
}

export default Message;
