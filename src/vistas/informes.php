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
    <div id="informes">
        <v-card class="mx-auto" :class="[`elevation-0`]" max-width="900">
            <v-layout>
                <v-app-bar color="#6a1c37">
                    
                    <v-btn
                        color="white"
                        icon="mdi-file-cloud"
                        @click="goToDocumentos"
                    >
                    </v-btn>
                    
                    <v-btn
                        color="white"
                        @click ="CerrarSesion"
                        icon="mdi-logout-variant"
                    >
                    </v-btn>

                    <v-spacer></v-spacer>

                    <div class="text-center">
                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn
                                color="white"
                                v-bind="props"
                            >
                            {{ userName }}
                            </v-btn>
                        </template>
                    </v-menu>
                    </div>
                </v-app-bar>

                <v-main>
                    <v-container fluid>
                    <v-row dense>
                        <v-col>
                            <v-card class="mx-auto" :class="[`elevation-5`]">
                                <v-card-text v-if="vista == 'informes'">
                                    <span style="font-weight: 600; font-size: 1.1rem;">Aqui pudes descargar el informe vacio para su llenado.</span>
                                    <br>
                                    <br>
                                    <v-btn
                                        append-icon="mdi-download"
                                        @click="descargarPInforme"
                                    >
                                        Descargar informe
                                    </v-btn>
                                    <br>
                                    <br>
                                    <v-divider></v-divider>
                                    <br>
                                    <br>
                                    <span style="font-weight: 600; font-size: 1.1rem;">Subir el informe llenado.</span>
                                    <br>
                                    <span class="text-caption text-grey">Solo PDF</span>
                                    <br>
                                    <br>
                                    <v-file-input
                                        show-size
                                        counter
                                        density="compact"
                                        accept=".pdf"
                                        v-model="archivo"
                                        label="Click aqui para subir el documento"
                                    ></v-file-input>
                                    <v-btn
                                        color="green"
                                        variant="flat"
                                        @click="subirArchivo(`firmado${informes.length + 1}`)"
                                        :disabled="( archivo.length < 1 || informes.length == 10 ) ? true : false"
                                    >
                                        Subir
                                    </v-btn>
                                    <br>
                                    <br>
                                    <v-divider v-if="informes.length > 0"></v-divider>
                                    <br>
                                    <br>
                                    <v-expansion-panels
                                    v-model="panel"
                                    multiple
                                    v-if="informes.length > 0"
                                    >
                                        <v-expansion-panel>
                                            <v-expansion-panel-title>Informes</v-expansion-panel-title>
                                            <v-expansion-panel-text>
                                                <v-list lines="one">
                                                    <v-list-item
                                                        v-for="documento in informes"
                                                        :key="documento.id"
                                                        :title="documento.proceso"
                                                        :subtitle="documento.nombre_documento"
                                                    >
                                                        <template v-slot:append>
                                                            <v-btn
                                                                icon="mdi-download-circle-outline"
                                                                variant="tonal"
                                                                @click="downloadDocument(documento.nombre_documento, documento.proceso)"
                                                            ></v-btn>
                                                        </template>
                                                    </v-list-item>
                                                </v-list>
                                            </v-expansion-panel-text>
                                        </v-expansion-panel>
                                    </v-expansion-panels>
                                    <v-divider></v-divider>
                                    <br>
                                    <br>
                                    <div v-if="cartaLiberacionExist.length < 1">
                                        <span style="font-weight: 600; font-size: 1.1rem;">Una vez terminado los informes aquí puedes subir la carta de liberación</span>
                                        <br>
                                        <br>
                                        <v-btn
                                            append-icon="mdi-upload"
                                            @click="vista = 'cartaLiberacion', archivo = []"
                                        >
                                            Subir carta de liberación
                                        </v-btn>
                                    </div>
                                </v-card-text>
                                <v-card-text v-if="vista == 'cartaLiberacion'">
                                    <v-alert v-show="showAlertCarta" title="Archivo subido con exito" closable type="success"></v-alert>
                                    <span style="font-weight: 600; font-size: 1.1rem;">Subir Carta de liberación</span>
                                    <br>
                                    <span class="text-caption text-grey">Solo PDF</span>
                                    <br>
                                    <br>
                                    <v-file-input
                                        show-size
                                        counter
                                        density="compact"
                                        accept=".pdf"
                                        v-model="archivo"
                                        label="Click aqui para subir el documento"
                                    ></v-file-input>
                                    <v-btn
                                        color="green"
                                        variant="flat"
                                        @click="subirArchivo(`carta_liberacion`)"
                                        :disabled="( archivo.length < 1 ) ? true : false"
                                    >
                                        Subir
                                    </v-btn>

                                    <div class="d-flex justify-center" style="margin-top: 10px; margin-bottom: 10px;">
                                        <v-btn icon="mdi-arrow-left" @click="vista = 'informes'"></v-btn>
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                    </v-container>
                </v-main>
            </v-layout>
        </v-card>
    </div>

    <script type="module" src="../modulos/informes.js"></script>
</body>
</html>