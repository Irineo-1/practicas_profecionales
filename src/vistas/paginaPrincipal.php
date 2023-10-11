<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Practicas Profesionales</title>
    <!-- librerias de front-end -->
    <?php include('src/componentes/vueKit.php'); ?>
    <!-- librerias de front-end -->
</head>
<body>
    <div id="paginaPrincipal">
        <v-card class="mx-auto" :class="[`elevation-0`]">
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
                            Nombre del alumno
                            <v-icon>mdi-chevron-down</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item value="1">
                                <template v-slot:prepend>
                                    <v-icon>mdi-account-circle</v-icon>
                                </template>
                                <v-list-item-title>Perfil</v-list-item-title>
                            </v-list-item>
                            <v-list-item value="2">
                                <template v-slot:prepend>
                                    <v-icon>mdi-account-off </v-icon>
                                </template>
                                <v-list-item-title>Cerrar sesión</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                    </div>
                </v-app-bar>

                <v-main>
                    <v-container fluid>
                    <v-row dense>
                        <v-col>
                            <v-card class="mx-auto">
                                <v-card-title class="text-h6 font-weight-regular justify-space-between">
                                <span style="margin-right: 10px;">{{tituloApartados[step]}}</span>
                                <v-avatar
                                    color="#6a1c37"
                                    size="30"
                                    v-text="step +1"
                                ></v-avatar>
                                </v-card-title>

                                <v-window v-model="step">
                                <v-window-item :value="0">
                                    <v-card-text>
                                        <span style="font-weight: 600; font-size: 1.1rem;">¿Has realizado ya tu servicio social?</span>
                                        <br>
                                        <br>
                                        <v-row>
                                            <v-col
                                                cols="12"
                                                class="py-2"
                                            >
                                                <v-btn-toggle
                                                v-model="respuestaPrimerPregunta"
                                                rounded="0"
                                                color="#6a1c37"
                                                group
                                                >
                                                    <v-btn value="si">
                                                        Si
                                                    </v-btn>

                                                    <v-btn value="no">
                                                        No
                                                    </v-btn>
                                                </v-btn-toggle>
                                            </v-col>
                                        </v-row>
                                        <br>
                                        <span
                                            v-show="respuestaPrimerPregunta == 'no'"
                                            style="font-weight: 600; color: #6a1c37"
                                        >
                                            No puedes realizar tus practicas profesionales si no tienes tu servicio
                                        </span>
                                    </v-card-text>
                                </v-window-item>

                                <v-window-item :value="1">
                                    <v-card-text>
                                    <v-text-field
                                        label="Password"
                                        type="password"
                                    ></v-text-field>
                                    <v-text-field
                                        label="Confirm Password"
                                        type="password"
                                    ></v-text-field>
                                    <span class="text-caption text-grey-darken-1">
                                        Please enter a password for your account
                                    </span>
                                    </v-card-text>
                                </v-window-item>

                                <v-window-item :value="2">
                                    <div class="pa-4 text-center">
                                    <v-img
                                        class="mb-4"
                                        contain
                                        height="128"
                                        src="https://cdn.vuetifyjs.com/images/logos/v.svg"
                                    ></v-img>
                                    <h3 class="text-h6 font-weight-light mb-2">
                                        Welcome to Vuetify
                                    </h3>
                                    <span class="text-caption text-grey">Thanks for signing up!</span>
                                    </div>
                                </v-window-item>
                                </v-window>

                                <v-divider></v-divider>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="#6a1c37"
                                        variant="flat"
                                        @click="siguientePaso"
                                        :disabled="(respuestaPrimerPregunta == 'no') ? true : false"
                                    >
                                        Siguiente
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                    </v-row>
                    </v-container>
                </v-main>
            </v-layout>
        </v-card>
    </div>

    <script type="module" src="src/modulos/paginaPrincipal.js"></script>
</body>
</html>