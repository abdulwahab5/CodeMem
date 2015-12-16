package symbolTable;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

public class SymbolTableVersion1 {
public static void main(String args[]) throws IOException
{
	String line;
	HashMap<Integer, List<String>> hash=new HashMap<Integer,List<String>>();
	
	File f=new File("code.txt");
    FileReader fl=new FileReader(f);
    BufferedReader bf=new BufferedReader(fl);
    System.out.print("Line no. \t Datatype \t Variable \t Current Value");
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
				System.out.print("\n"+line_no+"\t\t ");
				symbol.add(line1[0]);
				System.out.print(line1[0]+"\t\t ");
					if(line2[k].contains("=")==true){
					line3=line2[k].split("=");
					for(int l=0;l<line3.length;l++){
					symbol.add(line3[l]);
					System.out.print(line3[l]+"\t\t ");
					}
					}
					else
					{
						symbol.add(line2[k]);
						symbol.add(null);
						System.out.print(line2[k]+"\t\t NULL");
					}
					symbol.add(scope.toString());
					symbol.add(declared.toString());
				}
			
			hash.put(line_no, symbol);}
		else if(tokens[i].contains("String")==true )
		{	declared=true;
			line1=tokens[i].split("[ ]+",2);
			if(line1[1].contains("\""))
			{	
				line1[1]= line1[1].substring(0,line1[1].indexOf('\"')).replaceAll("[ ]+", "") + line1[1].substring(line1[1].indexOf('\"'));
				line1[1]=line1[1].replaceAll("\"", "");
			}
			else {line1[1].replaceAll("[ ]+","");}
			line2=line1[1].split(",");
					
				for(int k=0; k<line2.length;k++)
				{	line2[k]=line2[k].trim();
					if(line2[k].contains("\""))
					{
						line2[k]=line2[k].substring(0,line2[k].indexOf('\"')).replaceAll("[ ]+", "")+line2[k].substring(line2[k].indexOf('\"'));
						line2[k]=line2[k].replaceAll("\"", "");
					}
					else {line2[k].replaceAll("[ ]+","");
					}//System.out.print("\n"+line2[k]);
				System.out.print("\n"+line_no+"\t\t ");
				symbol.add(line1[0]);
				System.out.print(line1[0]+"\t\t ");
					if(line2[k].contains("=")==true){
					line3=line2[k].split("=");
					for(int l=0;l<line3.length;l++){
					symbol.add(line3[l]);
						System.out.print(line3[l]+"\t\t ");
					}
					}
					else
					{
						symbol.add(line2[k]);
						symbol.add(null);
						System.out.print(line2[k]+"\t\t NULL");
					}
					symbol.add(scope.toString());
					symbol.add(declared.toString());
					}
			hash.put(line_no, symbol);}
		else if(tokens[i].contains("char")==true )
		{	declared=true;
		
			line1=tokens[i].split("[ ]+",2);
			if(line1[1].contains("\'")==true)
			{
				line1[1]=line1[1].substring(0,line1[1].indexOf('\'')).replaceAll("[ ]+", "")+line1[1].substring(line1[1].indexOf('\''));
				line1[1]=line1[1].replaceAll("\'", "");
			}
			else line1[1].replaceAll("[ ]+","");
			line2=line1[1].split(",");
			
				for(int k=0; k<line2.length;k++)
				{	line2[k]=line2[k].trim();
					//System.out.print("\n"+line2[k]);
					if(line2[k].contains("\'")==true)
					{
						line2[k]=line2[k].substring(0,line2[k].indexOf('\'')).replaceAll("[ ]+", "")+line2[k].substring(line2[k].indexOf('\''));
						line2[k]=line2[k].replaceAll("\'", "");
					}
					else {line2[k].replaceAll("[ ]+","");}
					System.out.print("\n"+line_no+"\t\t ");
				symbol.add(line1[0]);
					System.out.print(line1[0]+"\t\t ");
					if(line2[k].contains("=")==true){
					line3=line2[k].split("=");
					for(int l=0;l<line3.length;l++){
					symbol.add(line3[l]);
						System.out.print(line3[l]+"\t\t ");
					}
					}
					else
					{
						symbol.add(line2[k]);
						symbol.add(null);
						System.out.print(line2[k]+"\t\t NULL");
					}
					symbol.add(scope.toString());
					symbol.add(declared.toString());	
				}
			hash.put(line_no, symbol);}
		/*else if(tokens[i].equals("=")==true)
		{
			List<String> previous=new ArrayList<String>();
			declared=false;
		line1=tokens[i].split("=");
		for(int j=0;j<=line1.length;j++){
		if(j==line1.length)
		{
		line1[j].replaceFirst("[ ]+", "");
		if(line1[j].contains("\"")==true){
		line1[j].replaceAll("\"", "");
		line1[]
		}
		
		line1[j].replaceAll("\'","");
		
		}
			line1[j]=line1[j].replaceAll("[ ]+","");
		for(int k=line_no-1;k>=0;k--){	
		previous=hash.get(k);
		for(int l=1;l<=previous.size();l=+5)
		{
			if(line1[j]==previous.get(l))
			{
				if(scope<=Integer.parseInt(previous.get(l+2))){
				symbol.add(previous.get(l-1));
				symbol.add(previous.get(l));
				}}
		}
		}
			/*
			for(int k=0; k<line2.length;k++)
			{	//System.out.print("\n"+line2[k]);
			System.out.print("\n"+line_no+"\t\t ");
			symbol.add(line1[0]);
			System.out.print(line1[0]+"\t\t ");
				if(line2[k].contains("=")==true){
				line3=line2[k].split("=");
				for(int l=0;l<line3.length;l++){
				symbol.add(line3[l]);
				System.out.print(line3[l]+"\t\t ");
				}
				}
				else
				{
					symbol.add(line2[k]);
					symbol.add(null);
					System.out.print(line2[k]+"\t\t NULL");
				}
				symbol.add(scope.toString());
				symbol.add(declared.toString());
			}
		
		hash.put(line_no, symbol);}*/
	
	}
	}
System.out.println("\nHashMap Generated:\n"+hash);}

}
