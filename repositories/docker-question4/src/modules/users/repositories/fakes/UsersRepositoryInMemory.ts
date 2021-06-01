import IRegisterUserDTO from "../../dtos/IRegisterUserDTO"
import IUsersRepository from "../IUsersRepository"
import { v4 as uuid } from 'uuid'
import User from "../../infra/typeorm/entities/User"

export default class UsersRepositoryInMemory implements IUsersRepository {
    private users: User[] = []

    create(data: IRegisterUserDTO): Promise<User> {
        const user = new User()
        Object.assign(user, {
            ...data,
            id: uuid(),
            created_at: new Date()
        })

        this.users.push(user)

        return Promise.resolve(user)
    }
    findByEmail(email: string): Promise<User | undefined> {
        const user = this.users.find(user => user.email === email)
        return Promise.resolve(user)
    }

    findById(id: string): Promise<User | undefined> {
        const user = this.users.find(user => user.id === id)
        return Promise.resolve(user)
    }

}