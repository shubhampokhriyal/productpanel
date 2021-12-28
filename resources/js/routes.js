import ProductIndex from './components/products/Index'
import ProductCreate from './components/products/Create'
import ProductEdit from './components/products/Edit'

export const routes = [
    {
        path: '/products',
        name: 'ProductIndex',
        component: ProductIndex
    },
    {
        path: '/product/create',
        name: 'ProductCreate',
        component: ProductCreate
    },
    {
        path: '/product/:id',
        name: 'ProductEdit',
        component: ProductEdit
    },
]