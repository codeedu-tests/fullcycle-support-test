import {Entity, model, property} from '@loopback/repository';

export interface SmallCategory{
    id: string;
    name: string;
    is_active: boolean;
}
@model()
export class Category extends Entity {
    @property({
        type: 'string',
        id: true,
        generated: false,
        required: true,
    })
    id: string;

    @property({
        type: 'string',
        required: true,
        jsonSchema: {
            minLength: 1,
            maxLength: 255,
        }
    })
    name: string;

    @property({
        type: 'string',
        required: false,
        jsonSchema: {
            nullable: true
        },
        default: null
    })
    description?: string;

    @property({
        type: 'boolean',
        required: false,
        default: true
    })
    // eslint-disable-next-line @typescript-eslint/naming-convention
    is_active: boolean;

    @property({
        type: 'date',
        required: true,
    })
    // eslint-disable-next-line @typescript-eslint/naming-convention
    created_at: string;

    @property({
        type: 'date',
        required: true,
    })
    // eslint-disable-next-line @typescript-eslint/naming-convention
    updated_at: string;

    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    [prop: string]: any;

    constructor(data?: Partial<Category>) {
        super(data);
    }
}

export interface CategoryRelations {
    // describe navigational properties here
}

export type CategoryWithRelations = Category & CategoryRelations;
