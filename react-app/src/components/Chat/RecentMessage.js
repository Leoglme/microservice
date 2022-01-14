import React from 'react';
import Avatar from "../common/Avatar";
import {dateToHour} from "../../common";
import clsx from "clsx";
import LastMessage from "./LastMessage";

function RecentMessage({discussion, active}) {

    const lastMessage = discussion.messages[discussion.messages.length - 1];

    return (<>
        <div className={clsx('recent-message space-between', active ? 'active' : null)}>
            <Avatar image={lastMessage.sender.image}/>
            <div className="space-between" style={{flex: '1'}}>
                <div style={{marginLeft: 20}}>
                    <span className="discussion-name">
                    {discussion.name}
                </span>
                    <LastMessage lastMessage={lastMessage}/>
                </div>
                {discussion.notifications
                    ? <span className="notification">{discussion.notifications}</span>
                    : <span className="small time">{dateToHour(discussion.updated_at)}</span>}
            </div>
        </div>
    </>);
}

export default RecentMessage;
