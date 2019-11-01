main(){
	int i, j; //indices das linhas e colunas
	float notas[5][4]; // declaração da matriz 5 x 4
	
	for(i = 0; i < 5; i++){
		for(i = 0; i < 5; i++){
			printf("\nDigite a nota do %d do aluno %d: ");
			scanf("%f", &notas[i][j]);
		}
		
	}
}





main(){
	float A[4][4] = { {2,3,0,0}, {0,2,0,0}, {0,0,2,0}, {0,0,0,2} };
	float B[4][4] = { {4,3,0,0}, {0,4,0,0}, {0,0,4,0}, {0,0,0,4} };
	float C[4][4];
	int i,j,k;
	
	printf("Matriz A=\n");
	for(i=0;i<4;i++) {
		for(j=0;j<4;j++) {
			printf("%6.2f ",A[j][i]);
		}

		printf("\n");
	}
	
	printf("Matriz B=\n");
		for(i=0;i<4;i++) {
			for(j=0;j<4;j++) {
			printf("%6.2f ",B[j][i]);
		}
		printf("\n");
	}
	
	for(i=0;i<4;i++)
		for(j=0;j<4;j++) {
			C[j][i] = 0.0;
			for(k=0;k<4;k++)
				C[j][i] += A[k][i] * B[j][k];
			}
			printf("Matriz C=\n");
			for(i=0;i<4;i++) {
				for(j=0;j<4;j++) {
				printf("%6.2f ",C[j][i]);
			}
			printf("\n");
		}
}