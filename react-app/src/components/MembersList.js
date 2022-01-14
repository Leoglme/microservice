import React from 'react';
import Spinner from "./common/Spinner";
import {ReactComponent as MoreCircle} from '../assets/icons/curved/MoreCircle.svg';
import {ReactComponent as Chat} from '../assets/icons/curved/Chat.svg';
import Avatar from "./common/Avatar";
import clsx from "clsx";

function MembersList({users}) {


    const List = (
        users.length > 0 ? <ul>
            {users.map((user, index) => {
                return (<li className={'start'} key={index}
                        style={{marginBottom: 12, fontSize: 13, minWidth: 230}}>
                        <Avatar image={user.image} user={user} size={25} mr={12}/>
                        {user.name}
                        <div className={clsx('end', 'icon-clickable')}>
                            <Chat className={'lighten'}/>
                        </div>
                    </li>)
            })}
        </ul> : <Spinner/>
    )
    return (<>
        <div className="column_container details">
            <div className="column_header">
                <MoreCircle/>
                <h6 className={'text-h6'} style={{marginLeft: 16}}>Chat Details</h6>
            </div>
            <span className="small lighten start" style={{marginBottom: 16}}>
                Members
                <span className="text-white lh-0"
                      style={{fontSize: 14, marginLeft: 5}}>
                    {users.length}
                </span>
            </span>
            {List}
        </div>
    </>);
}

export default MembersList;
