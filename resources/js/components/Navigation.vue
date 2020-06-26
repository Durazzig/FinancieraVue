<template>
    <v-list>
        <v-list-item dark to="/">
            <v-list-item-icon>
                    <v-icon>mdi-home</v-icon>
            </v-list-item-icon>
            <v-list-item-title><strong>Home</strong></v-list-item-title>
        </v-list-item>
        <v-list-item dark to="/clients">
            <v-list-item-icon>
                <v-icon>mdi-account-tie</v-icon>
            </v-list-item-icon>
            <v-list-item-title><strong>Clientes</strong></v-list-item-title>
        </v-list-item>
        <v-list-item dark to="/loans">
            <v-list-item-icon>
                <v-icon>mdi-currency-usd</v-icon>
            </v-list-item-icon>
            <v-list-item-title><strong>Prestamos</strong></v-list-item-title>
        </v-list-item>
        <v-list-item dark to="/payments">
            <v-list-item-icon>
                <v-icon>mdi-cash</v-icon>
            </v-list-item-icon>
            <v-list-item-title><strong>Pagos</strong></v-list-item-title>
        </v-list-item>
        <v-list-item dark to="/user">
            <v-list-item-title>
                <v-list-item-icon>
                    <v-icon>mdi-account-cog</v-icon>
                </v-list-item-icon>
                <strong>Usuario</strong>
            </v-list-item-title>
        </v-list-item>
    </v-list>
</template>
