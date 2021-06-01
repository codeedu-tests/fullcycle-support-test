import UsersRepositoryInMemory from '../../repositories/fakes/UsersRepositoryInMemory'
import CreateUserService from "../createUser/CreateUserService"
import AuthenticateUserService from "./AuthenticateUserService"
import AppError from "../../../../shared/errors/AppError"

let userRepositoryInMemory: UsersRepositoryInMemory
let createUserService: CreateUserService
let authenticateUserService: AuthenticateUserService

describe("Authenticate User", () => {

    beforeEach(() => {
        userRepositoryInMemory = new UsersRepositoryInMemory()
        createUserService = new CreateUserService(userRepositoryInMemory)
        authenticateUserService = new AuthenticateUserService(userRepositoryInMemory)
    })

    it("should be able to authenticate an user", async () => {
        const password = '123321'

        const user = await createUserService.execute({
            name: 'User Test',
            email: 'user@test.com',
            password
        })

        const response = await authenticateUserService.execute({
            email: user.email,
            password: password
        })

        expect(response).toHaveProperty('token')
    })

    it("should not be able to authenticate a none existing user", async () => {
        expect(authenticateUserService.execute({
            email: 'rhadamez@gmail.com',
            password: '123321'
        })).rejects.toBeInstanceOf(AppError)
    })

    it("should not be able to authenticate an user with incorrect password", async () => {
        const password = '123321'

        const user = await createUserService.execute({
            name: 'User Test',
            email: 'user@test.com',
            password
        })

        expect(authenticateUserService.execute({
            email: user.email,
            password: '123456'
        })).rejects.toBeInstanceOf(AppError)
    })
})
