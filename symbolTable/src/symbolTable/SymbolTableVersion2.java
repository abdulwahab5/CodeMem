package symbolTable;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Set;
import java.util.TreeMap;


import org.apache.commons.lang3.math.NumberUtils;

public class SymbolTableVersion2 {
	public static void main(String args[]) throws IOException
	{
		String line;
		TreeMap<Integer, List<String>> treemap=new TreeMap<Integer,List<String>>(Collections.reverseOrder());

		File f=new File("code.txt");
		FileReader fl=new FileReader(f);
		BufferedReader bf=new BufferedReader(fl);
		//System.out.print("Line no. \t Datatype \t Variable \t Current Value");
		int line_no=0;
		Integer scope=0;
		Boolean declared;
		while((line=bf.readLine())!=null){
			List<String> symbol=new ArrayList<String>();

			line_no++;
			String delims = ";";
			String[] tokens = line.split(delims);
			String[] line1 = null;
			String[] line2 = null;
			String[] line3=null;
			for (int i = 0; i < tokens.length; i++)
			{	if(tokens[i].startsWith(" ")==true)
			{
				tokens[i]=tokens[i].replaceFirst("[ ]+","");
			}
			if(tokens[i].contains("{")==true)
			{
				scope++;
			}
			if(tokens[i].contains("}")==true)
			{
				scope--;
			}

			if(tokens[i].contains("int")==true || tokens[i].contains("float")==true)
			{	declared=true;
			line1=tokens[i].split("[ ]+",2);

			line1[1]=line1[1].replaceAll("[ ]+","");
			line2=line1[1].split(",");

			for(int k=0; k<line2.length;k++)
			{	//System.out.print("\n"+line2[k]);
			//	System.out.print("\n"+line_no+"\t\t ");
				symbol.add(line1[0]);
				//System.out.print(line1[0]+"\t\t ");
				if(line2[k].contains("=")==true){
					line3=line2[k].split("=");
					for(int l=0;l<line3.length;l++){
						symbol.add(line3[l]);
						//System.out.print(line3[l]+"\t\t ");
					}
				}
				else
				{
					symbol.add(line2[k]);
					symbol.add(null);
					//System.out.print(line2[k]+"\t\t NULL");
				}
				symbol.add(scope.toString());
				symbol.add(declared.toString());
			}

			treemap.put(line_no, symbol);}
			else if(tokens[i].contains("String")==true )
			{	declared=true;

			line1=tokens[i].split("[ ]+",2);
			if(line1[1].contains("\""))
			{
				line1[1]=line1[1].substring(0,line1[1].indexOf('\"')).replaceAll("[ ]+", "")+line1[1].substring(line1[1].indexOf('\"'));
				line1[1]=line1[1].replaceAll("\"", "");
			}
			else line1[1].replaceAll("[ ]+","");
			line2=line1[1].split(",");

			for(int k=0; k<line2.length;k++)
			{	line2[k]=line2[k].trim();
			if(line2[k].contains("\'"))
			{
				line2[k]=line2[k].substring(0,line2[k].indexOf('\"')).replaceAll("[ ]+", "")+line2[k].substring(line2[k].indexOf('\"'));
				line2[k]=line2[k].replaceAll("\"", "");
			}
			else {line2[k].replaceAll("[ ]+","");}//System.out.print("\n"+line2[k]);
			//System.out.print("\n"+line_no+"\t\t ");
			symbol.add(line1[0]);
			//System.out.print(line1[0]+"\t\t ");
			if(line2[k].contains("=")==true){
				line3=line2[k].split("=");
				for(int l=0;l<line3.length;l++){
					symbol.add(line3[l]);
					//System.out.print(line3[l]+"\t\t ");
				}
			}
			else
			{
				symbol.add(line2[k]);
				symbol.add(null);
				//System.out.print(line2[k]+"\t\t NULL");
			}
			symbol.add(scope.toString());
			symbol.add(declared.toString());
			}
			treemap.put(line_no, symbol);}
			else if(tokens[i].contains("char")==true )
			{	declared=true;

			line1=tokens[i].split("[ ]+",2);
			if(line1[1].contains("\'"))
			{
				line1[1]=line1[1].substring(0,line1[1].indexOf('\'')).replaceAll("[ ]+", "")+line1[1].substring(line1[1].indexOf('\''));
				line1[1]=line1[1].replaceAll("\'", "");
			}
			else line1[1].replaceAll("[ ]+","");
			line2=line1[1].split(",");

			for(int k=0; k<line2.length;k++)
			{	//System.out.print("\n"+line2[k]);
				line2[k]=line2[k].trim();

				if(line2[k].contains("\'"))
				{
					line2[k]=line2[k].substring(0,line2[k].indexOf('\'')).replaceAll("[ ]+", "")+line2[k].substring(line2[k].indexOf('\''));

					line2[k]=line2[k].replaceAll("\'", "");
				}
				else {line2[k].replaceAll("[ ]+","");}
				//System.out.print("\n"+line_no+"\t\t ");
				symbol.add(line1[0]);
				//System.out.print(line1[0]+"\t\t ");
				if(line2[k].contains("=")==true){
					line3=line2[k].split("=");
					for(int l=0;l<line3.length;l++){
						symbol.add(line3[l]);
						//System.out.print(line3[l]+"\t\t ");
					}
				}
				else
				{
					symbol.add(line2[k]);
					symbol.add(null);
					//System.out.print(line2[k]+"\t\t NULL");
				}
				symbol.add(scope.toString());
				symbol.add(declared.toString());	
			}
			treemap.put(line_no, symbol);}
			else if(tokens[i].contains("=")==true)
			{	//System.out.println("\nReached Here");
				List<String> previous=new ArrayList<String>();
				declared=false;
				line1=tokens[i].split("=");
				String type=null;
				
				for(int j=0;j<line1.length;j++)
				{ 	line1[j]=line1[j].trim();
					//System.out.println("Reached here too");
					if(j==line1.length-1)
					{	//System.out.println("Hello g"+type);
						

						if(line1[j].startsWith("\"")==true){
							line1[j]=line1[j].replaceFirst("\"", "");
							line1[j]=line1[j].substring(0, line1[j].lastIndexOf('\"'));
							symbol.add(line1[j]);
						}
						else if(line1[j].startsWith("\'")==true){
							line1[j]=line1[j].replaceFirst("\'", "");
							line1[j]=line1[j].substring(0, line1[j].lastIndexOf('\''));
							symbol.add(line1[j]);
						}
						else if (NumberUtils.isParsable(line1[j]))
						{	
							if(type.equals("int")){
								//System.out.println("i am here");
								
								Integer value=Integer.parseInt(line1[j]);
								symbol.add(value.toString());
							}
							else if(type=="float"){
								Float value=Float.parseFloat(line1[j]);
								symbol.add(value.toString());
							}}
							else{
								//System.out.println("Variable int");
								Set set = treemap.entrySet();
							    Iterator iterate = set.iterator();
								iterator1:
							    while(iterate.hasNext()) {
								      Map.Entry me = (Map.Entry)iterate.next();
								    
													previous=treemap.get(me.getKey());
													//System.out.println(line1[j]+"here it is");
													for(int l=1;l<previous.size();l=l+5)
													{ //System.out.println(previous.get(l)+"comes here12");
														if(line1[j].equals(previous.get(l)))
														{	//System.out.println("comes here13");
															if(scope<=Integer.parseInt(previous.get(l+2))){
																//System.out.println("\nReached Hereas well");
																symbol.add(previous.get(l+1));
																
																l=previous.size()+1;
																break iterator1;
															
															}}

													}

									}
							}}
						else{
				Set set = treemap.entrySet();
			    Iterator iterate = set.iterator();
			    // Display elements
			    iterator:
			    while(iterate.hasNext()) {
			      Map.Entry me = (Map.Entry)iterate.next();
			    
								previous=treemap.get(me.getKey());
								//System.out.println(line1[j]+"here it is");
								for(int l=1;l<previous.size();l=l+5)
								{ //System.out.println(previous.get(l)+"comes here12");
									if(line1[j].equals(previous.get(l)))
									{	//System.out.println("comes here13");
										if(scope<=Integer.parseInt(previous.get(l+2))){
											//System.out.println("\nReached Hereas well");
											symbol.add(previous.get(l-1));
											symbol.add(previous.get(l));
											type=previous.get(l-1);
											break iterator;
											
										
										}}

								}

				}}
					}
				symbol.add(scope.toString());
				symbol.add(declared.toString());
				treemap.put(line_no, symbol);}}}
		System.out.println("\nTreeMap Generated:\n"+treemap);
		System.out.println("\nLine_no\t\tType\t\tVariable\tValue\t\tScope\t\tDeclared Here");
		List<String> display=new ArrayList<String>();
		Set set = treemap.entrySet();
	    Iterator iterate = set.iterator();
	    // Display elements
	    while(iterate.hasNext()) {
	      Map.Entry me = (Map.Entry)iterate.next();
	    display=treemap.get(me.getKey());
						for(int l=0;l<display.size();l++)
						{ 	if(l%5==0){
							System.out.print("\n"+me.getKey()+"\t\t");}
						System.out.print(display.get(l)+"\t\t");
						}
						}


	}

}
