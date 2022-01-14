import React from 'react';
import {ReactComponent as Search} from "../../assets/icons/light/Search.svg";

function SearchBar(props) {
    return (<>
        <div className="search-box ps-12">
            <Search className={"icon-inner lighten"}/>
            <input type="text"
                   placeholder={'Search'}
                   style={{width: '100%', marginBottom: 16, marginTop: 16, paddingLeft: 'calc(1em + 10px + 8px)'}}
            />
        </div>
    </>);
}

export default SearchBar;
