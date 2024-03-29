<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Practicas Profesionales</title>
    <!-- librerias de front-end -->
    <?php include('../componentes/vueKit.php'); ?>
    <!-- librerias de front-end -->
    <style> body{background-image: url('../img/Pt.jpg'); background-position: center; background-size: cover; color:#FFFF;} </style>
</head>

<body>
    <div id="loginMaestros">
        
        <v-container style="height: 100vh;">
            <v-row
                align="center"
                no-gutters
                style="height: 100%;"
            >
                <v-col>
                    <v-card max-width="400" class="mx-auto" :class="[`elevation-5`]">
                        <v-tabs
                        v-model="tab"
                        align-tabs="center"
                        stacked
                        >
                            <v-tab value="tab-1">
                                <v-icon>mdi-account</v-icon>
                                Iniciar sesion
                            </v-tab>

                            <v-tab value="tab-2">
                                <v-icon>mdi-account-plus</v-icon>
                                Registrarse
                            </v-tab>
                        </v-tabs>

                        <v-window v-model="tab">
                            <!-- Seccion del login -->
                            <v-window-item value="tab-1">
                                <v-card>
                                    <v-container>
                                        <v-row>
                                            <v-col>
                                                <v-text-field
                                                    label="Correo"
                                                    :rules="emailRules"
                                                    variant="solo"
                                                    v-model="correoLogin"
                                                    Prepend-icon="mdi-email"
                                                >
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-text-field
                                                    label="Contraseña"
                                                    :type="typeInputPassword"
                                                    variant="solo"
                                                    Prepend-icon="mdi-lock-outline"
                                                    :append-inner-icon="iconIce"
                                                    @keyup.enter="iniciarSession"
                                                    v-model="passLogin"
                                                    @click:append-inner="toggleTypeOfInputPassword"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                    
                                    <v-divider class="mx-4 mb-1"></v-divider>
                                    
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            variant="elevated"
                                            color="green-lighten-1"
                                            :disabled="( correoLogin.trim() == '' || passLogin.trim() == '') ? true : false"
                                            @click="iniciarSession"
                                        >
                                            Iniciar
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-window-item>
                            <!-- Seccion del registro -->
                            <v-window-item value="tab-2">
                                <v-card>
                                        <v-container>
                                            <v-row>
                                                <v-col>
                                                    <v-text-field
                                                        label="Nombre completo"
                                                        type="text"
                                                        variant="solo"
                                                        v-model="nombreCompletoRegistro"
                                                        Prepend-icon="mdi-account"
                                                    >
                                                    </v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col>
                                                    <v-text-field
                                                        label="Correo"
                                                        :rules="emailRules"
                                                        variant="solo"
                                                        v-model="correoRegistro"
                                                        Prepend-icon="mdi-email"
                                                    >
                                                    </v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col>
                                                    <v-autocomplete
                                                        v-model="puesto"
                                                        :items="puestos"
                                                        label="Selecciona tu puesto"
                                                        variant="solo"
                                                        persistent-hint
                                                        prepend-icon="mdi-book-account"
                                                    >
                                                    </v-autocomplete>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col>
                                                    <v-autocomplete
                                                        v-model="turno"
                                                        :items="turnos"
                                                        label="Selecciona tu turno"
                                                        variant="solo"
                                                        prepend-icon="mdi-sun-clock"
                                                    >
                                                    </v-autocomplete>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col>
                                                    <v-text-field
                                                        label="Contraseña"
                                                        :type="typeInputPassword"
                                                        variant="solo"
                                                        Prepend-icon="mdi-lock-outline"
                                                        v-model="passRegister"
                                                        :append-inner-icon="iconIce"
                                                        @click:append-inner="toggleTypeOfInputPassword"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col>
                                                    <v-text-field
                                                        label="Repetir contraseña"
                                                        :type="typeInputPassword"
                                                        :append-inner-icon="iconIce"
                                                        :rules="samePasssword"
                                                        v-model="passRegisterRepeat"
                                                        variant="solo"
                                                        Prepend-icon="mdi-lock-outline"
                                                        @click:append-inner="toggleTypeOfInputPassword"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-container>

                                        <v-divider class="mx-4 mb-1"></v-divider>
                                        
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                variant="elevated"
                                                color="green-lighten-1"
                                                :disabled="( nombreCompletoRegistro.trim() == '' ||
                                                            correoRegistro.trim() == '' ||
                                                            puesto.trim() == '' ||
                                                            turno.trim() == '' ||
                                                            passRegister.trim() == '' ||
                                                            passRegisterRepeat.trim() == '' ||
                                                            passRegister != passRegisterRepeat ) ? true : false "
                                                @click="registrarUsuario"
                                            >
                                                Registrarse
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                            </v-window-item>
                        </v-window>
                    </v-card>
                </v-col>
            </v-row>

            <v-snackbar
            color="#6a1c37"
            rounded="pill"
            v-model="smsError"
            >
            {{texto_error}}

            <template v-slot:actions>
                <v-btn
                color="white"
                variant="text"
                @click="smsError = false"
                
                >
                cerrar
                </v-btn>
            </template>
            </v-snackbar>

        </v-container>
    </div>


    <script type="module" src="../modulos/loginMaestro.js"></script>

</body>
</html>