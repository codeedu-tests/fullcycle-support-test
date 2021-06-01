import * as React from 'react';
import {useEffect} from 'react';
import {
    Box,
    Button,
    ButtonProps,
    FormControl,
    FormControlLabel,
    FormLabel,
    makeStyles,
    Radio,
    RadioGroup,
    TextField
} from "@material-ui/core";
import {Theme} from "@material-ui/core/styles";
import useForm from "react-hook-form";
import castMemberHttp from "../../util/http/cast-member-http";

const useStyles = makeStyles((theme: Theme) => {
    return {
        submit: {
            margin: theme.spacing(1)
        }
    }
});

export const Form = () => {

    const classes = useStyles();

    const buttonProps: ButtonProps = {
        variant: "outlined",
        className: classes.submit
    };

    const {register, getValues, setValue, handleSubmit} = useForm();

    useEffect(() => {
        register({name: "type"});
    }, [register])

    function onSubmit(formData, event) {
        castMemberHttp.create(formData)
            .then(response => console.log(response));
    }

    return (
        <form onSubmit={handleSubmit(onSubmit)}>
            <TextField
                name={'name'}
                label={'Nome'}
                fullWidth
                variant={'outlined'}
                inputRef={register}
            />
            <FormControl margin={'normal'}>
                <FormLabel component={'legend'}>Tipo</FormLabel>
                <RadioGroup
                    name={'type'}
                    onChange={e => setValue('type', parseInt(e.target.value))}
                >
                    <FormControlLabel value={'1'} control={<Radio/>} label={'Diretor'}/>
                    <FormControlLabel value={'2'} control={<Radio/>} label={'Ator'}/>
                </RadioGroup>
            </FormControl>
            <Box dir={'rtl'}>
                <Button {...buttonProps} onClick={() => onSubmit(getValues(), null)} >Salvar</Button>
                <Button {...buttonProps} type={'submit'} >Salvar e continuar editando</Button>
            </Box>
        </form>
    );
};