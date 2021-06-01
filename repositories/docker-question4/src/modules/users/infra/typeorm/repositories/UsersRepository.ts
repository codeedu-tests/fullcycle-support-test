import { getRepository, Repository } from "typeorm"
import IRegisterUserDTO from "../../../dtos/IRegisterUserDTO"
import IUsersRepository from "../../../repositories/IUsersRepository"
import User from "../entities/User"

export default class UsersRepository implements IUsersRepository {
    private repository: Repository<User>

    constructor() {
        this.repository = getRepository(User)
    }

    async create(data: IRegisterUserDTO): Promise<User> {
        const user = this.repository.create(data)

        await this.repository.save(user)

        return user
    }

    async findByEmail(email: string): Promise<User | undefined> {
        return await this.repository.findOne({ where: { email } })
    }

    async findById(id: string): Promise<User | undefined> {
        return await this.repository.findOne({ where: { id } })
    }

}