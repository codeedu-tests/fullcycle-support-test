import * as React from 'react';
import MUIDataTable, {MUIDataTableColumn} from "mui-datatables";
import {useEffect, useState} from "react";
import {httpVideo} from "../../util/http";
import format from "date-fns/format";
import parseISO from "date-fns/parseISO";
import castMemberHttp from "../../util/http/cast-member-http";

const CastMemberTypeMap = {
    1: 'Diretor',
    2: 'Ator'
};

const columnsDefinition: MUIDataTableColumn[] = [
    {
        name: "name",
        label: "Nome"
    },
    {
        name: "type",
        label: "Tipo",
        options: {
            customBodyRender(value, tableMeta, updateValue) {
                return CastMemberTypeMap[value];
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


interface CastMember {
    id: string,
    name: string;
    type: string;
    created_at: string;
}

const Table = () => {
    const [data, setData] = useState<CastMember[]>([]);
    useEffect(() => {
        castMemberHttp.list<{ data: CastMember[] }>()
            .then(({data}) => setData(data.data));
        httpVideo.get('cast_members')
            .then(response => setData(response.data.data));
    }, []);

    return (
        <div>
            <MUIDataTable
                columns={columnsDefinition}
                data={data}
                title={"Listagem de membros de elencos"}
            />
        </div>
    );
};

export default Table;