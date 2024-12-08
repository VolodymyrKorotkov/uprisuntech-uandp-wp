import {Box, Typography} from "@mui/material";
import { t } from "../../../I18n/I18n";
import React from "react";

export const FieldWrapper = ({ children, label }) => {
    return (
        <Box className='col-md-6' sx={{width: '100%', height: '100%', display: 'flex', flexDirection: 'column', gap: '6px'}}>
            {label && <Typography sx={{marginTop: 'auto'}} color="text.secondary" variant='subtitle2'>
                { t(label) }
            </Typography>}
            {children}
        </Box>
    )
}