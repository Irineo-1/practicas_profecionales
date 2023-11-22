<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Practicas Profesionales</title>
    <!-- librerias de front-end -->
    <?php include('../componentes/vueKit.php'); ?>
</head>
<body>
    <div id="documentosAlumno">
        <v-card class="mx-auto" :class="[`elevation-0`]" max-width="900">
            <v-layout>
                <v-app-bar color="#6a1c37">
                    
                    <v-btn
                        color="white"
                        @click="goToInformes"
                        v-if="step == 5"
                    >
                        informes
                    </v-btn>
                    
                    <v-btn
                        color="white"
                        @click="goToProceso"
                        v-if="step < 5"
                    >
                        Proceso
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
                                    <v-list lines="one">
                                        <v-list-item
                                            v-for="documento in DOCconstancia_temino_servicio"
                                            :key="documento.id"
                                            :title="'Constancia de término del servicio social'"
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
                                    <v-list lines="one">
                                        <v-list-item
                                            v-for="documento in DOCsolicitud"
                                            :key="documento.id"
                                            :title="'Constancia de término del servicio social'"
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
                                    <v-list lines="one">
                                        <v-list-item
                                            v-for="documento in DOCcarta_aceptacion"
                                            :key="documento.id"
                                            :title="'Constancia de término del servicio social'"
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

                                    <v-expansion-panels
                                    v-model="panel"
                                    multiple
                                    v-if="DOCfirmado.length > 0"
                                    >
                                        <v-expansion-panel>
                                            <v-expansion-panel-title>Informes</v-expansion-panel-title>
                                            <v-expansion-panel-text>
                                                <v-list lines="one">
                                                    <v-list-item
                                                        v-for="documento in DOCfirmado"
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
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-main>
            </v-layout>
        </v-card>
    </div>

    <script type="module" src="../modulos/documentosAlumno.js"></script>
</body>
</html>