<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Practicas Profesionales</title>
    <!-- librerias de front-end -->
    <?php include('src/componentes/vueKit.php'); ?>
    <!-- librerias de front-end -->
    <style> body{background-image: url('src/img/Pt.jpg'); background-position: center; background-size: cover; color:#FFFF;} </style>
</head>

<body>

    
    <div id="login">
        
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
                        </v-tabs>

                        <v-window v-model="tab">
                            <!-- Seccion del login -->
                            <v-window-item value="tab-1">
                                <v-card>
                                    <v-container>
                                        <v-row>
                                            <v-col>
                                                <v-text-field
                                                    label="Numero de control"
                                                    type="number"
                                                    variant="solo"
                                                    Prepend-icon="mdi-account"
                                                    v-model="nControlLogin"
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
                                            :disabled="( nControlLogin.trim() == '') ? true : false"
                                            @click="iniciarSession"
                                        >
                                            Iniciar
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


    <script type="module" src="src/modulos/loginAlumno.js"></script>

</body>
</html>