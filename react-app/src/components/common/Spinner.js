import React from 'react';
import { css } from "@emotion/react";
import {ScaleLoader} from "react-spinners";


const override = css`
  display: block;
  margin: 0 auto;
  border-color: red;
  background: #161719;
`;

function Spinner(props) {
    const color = '#43a0ff';
    return (<>
        <ScaleLoader color={color} loading css={override} size={150} />
    </>);
}

export default Spinner;
