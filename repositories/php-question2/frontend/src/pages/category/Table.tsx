import * as React from 'react';
import {useEffect, useState} from 'react';
import MUIDataTable, {MUIDataTableColumn} from "mui-datatables";
import {Chip} from "@material-ui/core";
import format from "date-fns/format";
import parseISO from "date-fns/parseISO";
import categoryHttp from "../../util/http/category-http";

const columnsDefinition: MUIDataTableColumn[] = [
    {
        name: "name",
        label: "Nome"
    },
    {
        name: "is_active",
        label: "Ativo?",
        options: {
            customBodyRender(value, tableMeta, updateValue) {
                return value ? <Chip label={'Sim'} color={'primary'}/> : <Chip label={'Não'}  color={'secondary'}/>;
            }
        }
    },
    {
        name: "created_at",
        label: "Criado em",
        options: {
            customBodyRender(value, tableMeta, updateValue) {
                return <span>{format(parseISO(value), 'dd/MM/yyyy')}</span>;
            }
        }
    }
];

interface Category {
    id: string,
    name: string;
    is_active: boolean;
    created_at: string;
}

type Props = {

};
const Table = (props: Props) => {
    const [data, setData] = useState<Category[]>([]);
    useEffect(() => {
        categoryHttp.list<{ data: Category[] }>()
            .then(({data}) => setData(data.data));
    }, []);

    return (
        <div>
            <MUIDataTable
                columns={columnsDefinition}
                data={data}
                title={"Listagem de categorias"}
            />
        </div>
    );
};

export default Table;