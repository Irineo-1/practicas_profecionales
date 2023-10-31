<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Practicas Profesionales</title>
    <!-- librerias de front-end -->
    <?php include('../componentes/vueKit.php'); ?>
    <!-- librerias de front-end -->
</head>
<body>
    <div id="paginaPrincipal">
        <v-card class="mx-auto" :class="[`elevation-0`]" max-width="900">
            <v-layout>
                <v-app-bar color="#6a1c37">

                    <v-spacer></v-spacer>

                    <div class="text-center">
                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn
                                color="white"
                                v-bind="props"
                            >
                            {{ userName }}
                            <v-icon>mdi-chevron-down</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item value="2">
                                <template v-slot:prepend>
                                    <v-icon>mdi-account-off </v-icon>
                                </template>
                                
                                <v-list-item-title @click ="CerrarSesion">Cerrar sesión</v-list-item-title>
                                 
                            </v-list-item>
                        </v-list>
                    </v-menu>
                    </div>
                </v-app-bar>

                <v-main>
                    <v-container fluid>
                        <v-row dense>
                            <v-col>
                                <v-card class="mx-auto" :class="[`elevation-5`]">
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-main>
            </v-layout>
        </v-card>
    </div>

    <!-- <script type="module" src="src/modulos/paginaPrincipal.js"></script> -->
</body>
</html>