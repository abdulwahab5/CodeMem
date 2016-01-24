package symbolTable;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Map.Entry;
import java.util.Set;
import java.util.TreeMap;

import javax.script.ScriptEngine;
import javax.script.ScriptEngineManager;
import javax.script.ScriptException;

import org.apache.commons.lang3.math.NumberUtils;

public class SymbolTableVersion8 {
	private TreeMap<Integer, List<String>> treemap = new TreeMap<Integer, List<String>>(Collections.reverseOrder());
	Boolean declared;
	int line_no = 0;
	Integer scope = 0;
	String[] line1 = null;
	String[] line2 = null;
	String[] line3 = null;
	//static String inputFile;
	//static String outputFile;
	private void symbolTable() throws IOException, ScriptException {
		String line;
		File f = new File("E:/xampp/htdocs/codemem/uploads/code.txt");
		FileReader fl = new FileReader(f);
		BufferedReader bf = new BufferedReader(fl);
		// System.out.print("Line no. \t Datatype \t Variable \t Current
		// Value");
		while ((line = bf.readLine()) != null) {
			ArrayList<String> symbol = new ArrayList<String>();

			line_no++;
			String delims = ";";
			String[] tokens = line.split(delims);
			for (int i = 0; i < tokens.length; i++) {
				if (tokens[i].startsWith(" ") == true) {
					tokens[i] = tokens[i].replaceFirst("[ ]+", "");
				}
				if (tokens[i].contains("{") == true) {
					scope++;
				}
				if (tokens[i].contains("}") == true) {
					scope--;
				}

				if (tokens[i].contains("int") == true || tokens[i].contains("float") == true) {
					declared = true;
					symbol = intFloatDeclaration(symbol, tokens[i]);
					treemap.put(line_no, symbol);
				}

				else if (tokens[i].contains("String") == true) {
					declared = true;
					symbol = stringDeclaration(symbol, tokens[i]);
					treemap.put(line_no, symbol);
				}

				else if (tokens[i].contains("char") == true) {
					declared = true;

					symbol = charDeclaration(symbol, tokens[i]);
					treemap.put(line_no, symbol);
				}

				else if (tokens[i].contains("=") == true) {
					symbol = expression(tokens[i], symbol);
					treemap.put(line_no, symbol);
					// the condition for checking "=" ends here
				} else if (tokens[i].contains("++") || tokens[i].contains("--")) {
					declared = false;
					symbol = unary(tokens[i], symbol, "null", "null", symbol);
					treemap.put(line_no, symbol);
				}
				// the loop on line separated by ; ends here
			}
			// the loop on each line of file ends here
		}

		bf.close();

		System.out.println("\nTreeMap Generated:\n" + treemap);
		System.out.print("\nLine_no\t\tType\t\tVariable\tValue\t\tScope\t\tDeclared Here");
		List<String> display = new ArrayList<String>();
		Set<Entry<Integer, List<String>>> set = treemap.entrySet();
		Iterator<Entry<Integer, List<String>>> iterate = set.iterator();
		// Display elements
		//File file = new File("E:/xampp/htdocs/codemem/symbolTables/output.txt");
		//file.createNewFile();
		//PrintWriter writer=new PrintWriter(file);
		
		while (iterate.hasNext()) {
			@SuppressWarnings("rawtypes")
			Map.Entry me = (Map.Entry) iterate.next();
			display = treemap.get(me.getKey());
			for (int l = 0; l < display.size(); l++) {
				if (l % 5 == 0) {
					System.out.println();
					System.out.print(me.getKey());
				}
				System.out.print("\t\t"+display.get(l));
			}
		
		}
		//writer.close();
	}

	private ArrayList<String> intFloatDeclaration(ArrayList<String> symbol, String tokens) throws ScriptException {
		String type = null;
		String name = null;

		line1 = tokens.split("[ ]+", 2);

		line1[1] = line1[1].replaceAll("[ ]+", "");
		line2 = line1[1].split(",");

		for (int k = 0; k < line2.length; k++) { // System.out.print("\n"+line2[k]);
			// System.out.print("\n"+line_no+"\t\t ");
			type = line1[0];
			// System.out.print(line1[0]+"\t\t ");
			if (line2[k].contains("=") == true) {
				if (line2[k].contains("+=") || line2[k].contains("-=") || line2[k].contains("*=")
						|| line2[k].contains("/=") || line2[k].contains("%=")) {
					line2[k] = opEqual(line2[k]);
				}
				line3 = line2[k].split("=");
				for (int l = 0; l < line3.length; l++) {
					if (l != line3.length - 1) {
						name = line3[l];
					} else {
						if (NumberUtils.isParsable(line3[l])) {
							if (line1[0].equals("int")) {
								Integer value = (int) Double.parseDouble(line3[l]);
								symbol.add(type);
								symbol.add(name);
								symbol.add(value.toString());
							} else if (line1[0].equals("float")) {
								Float value = (float) Double.parseDouble(line3[l]);
								symbol.add(type);
								symbol.add(name);
								symbol.add(value.toString());
							}

						} else {
							symbol = arithmetic(line3[l], symbol, line1[0], name, null);
						}
					}
					// System.out.print(line3[l]+"\t\t ");
				}
			} else {
				symbol.add(type);
				symbol.add(line2[k]);
				symbol.add(null);
				// System.out.print(line2[k]+"\t\t NULL");
			}
			symbol.add(scope.toString());
			symbol.add(declared.toString());
		}
		return symbol;
	}

	private ArrayList<String> charDeclaration(ArrayList<String> symbol, String tokens) throws ScriptException {
		String name = null;
		String type = null;
		tokens = tokens.trim();
		line1 = tokens.split("[ ]+", 2);

		line2 = line1[1].split(",");

		for (int k = 0; k < line2.length; k++) { // System.out.print("\n"+line2[k]);
			line2[k] = line2[k].trim();
			line1[0] = line1[0].trim();
			type = line1[0];

			if (line2[k].contains("=") == true) {
				if (line2[k].contains("+=") || line2[k].contains("-=") || line2[k].contains("*=")
						|| line2[k].contains("/=") || line2[k].contains("%=")) {
					line2[k] = opEqual(line2[k]);
				}
				line3 = line2[k].split("=");
				for (int l = 0; l < line3.length; l++) {
					line3[l] = line3[l].trim();
					if (l != line3.length - 1) {

						name = line3[l];
					} else {

						if (NumberUtils.isDigits(line3[l])) {
							Character value = (char) Integer.parseInt(line3[l]);
							symbol.add(type);
							symbol.add(name);
							symbol.add(value.toString());
						} else if (line3[l].contains("\'")) {
							line3[l] = line3[l].substring(0, line3[l].indexOf('\'')).replaceAll("[ ]+", "")
									+ line3[l].substring(line3[l].indexOf('\''));
							line3[l] = line3[l].replaceAll("\'", "");
							symbol.add(type);
							symbol.add(name);
							symbol.add(line3[l]);
						} else {
							symbol = arithmetic(line3[l], symbol, line1[0], name, null);
						}
					}
				}
			} else {
				symbol.add(type);
				symbol.add(line2[k]);
				symbol.add(null);
				// System.out.print(line2[k]+"\t\t NULL");
			}
			symbol.add(scope.toString());
			symbol.add(declared.toString());
		}

		return symbol;
	}

	private ArrayList<String> stringDeclaration(ArrayList<String> symbol, String tokens) {

		line1 = tokens.split("[ ]+", 2);
		if (line1[1].contains("\"")) {
			line1[1] = line1[1].substring(0, line1[1].indexOf('\"')).replaceAll("[ ]+", "")
					+ line1[1].substring(line1[1].indexOf('\"'));
			line1[1] = line1[1].replaceAll("\"", "");
		} else
			line1[1].replaceAll("[ ]+", "");
		line2 = line1[1].split(",");

		for (int k = 0; k < line2.length; k++) {
			line2[k] = line2[k].trim();
			if (line2[k].contains("\'")) {
				line2[k] = line2[k].substring(0, line2[k].indexOf('\"')).replaceAll("[ ]+", "")
						+ line2[k].substring(line2[k].indexOf('\"'));
				line2[k] = line2[k].replaceAll("\"", "");
			} else {
				line2[k].replaceAll("[ ]+", "");
			} // System.out.print("\n"+line2[k]);
				// System.out.print("\n"+line_no+"\t\t ");
			symbol.add(line1[0]);
			// System.out.print(line1[0]+"\t\t ");
			if (line2[k].contains("=") == true) {
				line3 = line2[k].split("=");
				for (int l = 0; l < line3.length; l++) {
					symbol.add(line3[l]);
					// System.out.print(line3[l]+"\t\t ");
				}
			} else {
				symbol.add(line2[k]);
				symbol.add(null);
				// System.out.print(line2[k]+"\t\t NULL");
			}
			symbol.add(scope.toString());
			symbol.add(declared.toString());
		}
		return symbol;
	}

	private ArrayList<String> expression(String tokens, ArrayList<String> symbol) throws ScriptException {
		if (tokens.contains("+=") || tokens.contains("-=") || tokens.contains("*=") || tokens.contains("/=")
				|| tokens.contains("%=")) {
			tokens = opEqual(tokens);
		}
		line1 = tokens.split("=");
		declared = false;
		List<String> previous = new ArrayList<String>();
		String type = null;
		int last = line1.length - 1;
		line1[last] = line1[last].trim();
		for (int j = 0; j < line1.length - 1; j++) {
			Set<Entry<Integer, List<String>>> set = treemap.entrySet();
			Iterator<Entry<Integer, List<String>>> iterate = set.iterator();
			// Display elements
			iterator: while (iterate.hasNext()) {
				@SuppressWarnings("rawtypes")
				Map.Entry me = (Map.Entry) iterate.next();

				previous = treemap.get(me.getKey());
				
				for (int l = 1; l < previous.size(); l = l + 5) { 
					if (line1[j].equals(previous.get(l))) { 
						if (scope <= Integer.parseInt(previous.get(l + 2))) {
							type = previous.get(l - 1);
							String name = previous.get(l);

							if (line1[last].startsWith("\"") == true) {
								line1[last] = line1[last].replaceFirst("\"", "");
								line1[last] = line1[last].substring(0, line1[last].lastIndexOf('\"'));
								symbol.add(type);
								symbol.add(name);
								symbol.add(line1[last]);
								line1[last] = "\"" + line1[last] + "\"";
							} else if (line1[last].startsWith("\'") == true) {
								line1[last] = line1[last].replaceFirst("\'", "");
								line1[last] = line1[last].substring(0, line1[last].lastIndexOf('\''));
								symbol.add(type);
								symbol.add(name);
								symbol.add(line1[last]);
								line1[last] = "\'" + line1[last] + "\'";
							} else if (NumberUtils.isParsable(line1[last])) {
								if (type.equals("int")) {
									// System.out.println("i am here");

									Integer value = (int) Double.parseDouble(line1[last]);
									symbol.add(type);
									symbol.add(name);
									symbol.add(value.toString());
								} else if (type.equals("float")) {
									Float value = (float) Double.parseDouble(line1[last]);
									symbol.add(type);
									symbol.add(name);
									symbol.add(value.toString());
								} else if (type.equals("char")) {
									Character value = (char) Integer.parseInt(line1[last]);
									symbol.add(type);
									symbol.add(name);
									symbol.add(value.toString());
								}
							} else {
								
								if (!line1[last].contains("+") && !line1[last].contains("-")
										&& !line1[last].contains("/") && !line1[last].contains("%")
										&& !line1[last].contains("*") && !line1[last].contains("(")
										&& !line1[last].contains(")")) {
									Set<Entry<Integer, List<String>>> set1 = treemap.entrySet();
									Iterator<Entry<Integer, List<String>>> iterate1 = set1.iterator();
									iterator1: while (iterate1.hasNext()) {
										@SuppressWarnings("rawtypes")
										Map.Entry me1 = (Map.Entry) iterate1.next();

										previous = treemap.get(me1.getKey());
										for (int m = 1; m < previous.size(); m = m + 5) { 
											if (line1[last].equals(previous.get(m))) { 
												if (scope <= Integer.parseInt(previous.get(m + 2))) {
													symbol.add(type);
													symbol.add(name);
													symbol.add(previous.get(m + 1));

													m = previous.size() + 1;
													break iterator1;

												}

											}

										}
									}
								} else {
									if(line1[last].contains("++")||line1[last].contains("--")){
										symbol=unary(line1[last], symbol, type, name, previous);
									}
									else{
									symbol = arithmetic(line1[last], symbol, type, name, previous);
									}
								}
							}
							symbol.add(scope.toString());
							symbol.add(declared.toString());

							break iterator;
							
						}
						
					}
					
				}
				
			}
			
		}

		return (ArrayList<String>) symbol;

	}

	private ArrayList<String> unary(String expression, ArrayList<String> symbol, String type, String name,
			List<String> previous) throws ScriptException {

		while (expression.contains("++") || expression.contains("--")) {
				String unary = null;
				if (expression.contains("++")) {
					unary = "++";
				} else if (expression.contains("--")) {
					unary = "--";
				}
				int i = expression.indexOf(unary);
				// post unary
				if (i + 2 == expression.length() || (i + 2 < expression.length()
						&& (expression.charAt(i + 2) == '+' || expression.charAt(i + 2) == '-'
								|| expression.charAt(i + 2) == '*' || expression.charAt(i + 2) == '/'
								|| expression.charAt(i + 2) == '(' || expression.charAt(i + 2) == ')'))) {
					int j;
					for (j = i - 1; j >= 0 && expression.charAt(j) != '+' && expression.charAt(j) != '-'
							&& expression.charAt(j) != '*' && expression.charAt(j) != '/' && expression.charAt(j) != '('
							&& expression.charAt(j) != ')'; j--) {
					}

					Set<Entry<Integer, List<String>>> set1 = treemap.entrySet();
					Iterator<Entry<Integer, List<String>>> iterate1 = set1.iterator();
					iterator1: while (iterate1.hasNext()) {
						@SuppressWarnings("rawtypes")
						Map.Entry me1 = (Map.Entry) iterate1.next();

						previous = treemap.get(me1.getKey());
						// System.out.println(expression+"here it is");
						for (int m = 1; m < previous.size(); m = m + 5) { // System.out.println(previous.get(l)+"comes
							// here12");
							if (expression.substring(j + 1, i).equals(previous.get(m))) { // System.out.println("comes
								// here13");
								if (scope <= Integer.parseInt(previous.get(m + 2))) {
									// System.out.println("\nReached Hereas
									// well");

									expression = expression.replaceFirst(expression.substring(j + 1, i + 2),
											previous.get(m + 1));
									String Value = null;
									if (unary.equals("++")) {
										expression = expression.replaceFirst("\\+\\+", "");
										if (previous.get(m - 1).equals("int")) {
											Integer value = Integer.parseInt(previous.get(m + 1)) + 1;
											Value = value.toString();
										}

										else if (previous.get(m - 1).equals("float")) {
											Float value = Float.parseFloat(previous.get(m + 1)) + 1;
											Value = value.toString();

										}

										else if (previous.get(m - 1).equals("char")) {
											Character value = (char) (Integer.parseInt(previous.get(m + 1)) + 1);
											Value = value.toString();

										}
										symbol.add(previous.get(m - 1));
										symbol.add(previous.get(m));
										symbol.add(Value);
										symbol.add(scope.toString());
										symbol.add(declared.toString());

									} else if (unary.equals("--")) {
										expression = expression.replaceFirst("\\-\\-", "");
										if (previous.get(m - 1).equals("int")) {
											Integer value = Integer.parseInt(previous.get(m + 1)) - 1;
											Value = value.toString();
										}

										else if (previous.get(m - 1).equals("float")) {
											Float value = Float.parseFloat(previous.get(m + 1)) - 1;
											Value = value.toString();
										}

										else if (previous.get(m - 1).equals("char")) {
											Character value = (char) (Integer.parseInt(previous.get(m + 1)) - 1);
											Value = value.toString();
										}

										symbol.add(previous.get(m - 1));
										symbol.add(previous.get(m));
										symbol.add(Value);
										symbol.add(scope.toString());
										symbol.add(declared.toString());

									}
								}
								m = previous.size() + 1;
								break iterator1;

							}

						}

					}
				} // pre-unary
				else if (i == 0 || (i - 1 >= 0 && expression.charAt(i - 1) == '+' || expression.charAt(i - 1) == '-'
						|| expression.charAt(i - 1) == '*' || expression.charAt(i - 1) == '/'
						|| expression.charAt(i - 1) == '(' || expression.charAt(i - 1) == ')')) {
					int j;
					for (j = i + 2; j < expression.length() && expression.charAt(j) != '+'
							&& expression.charAt(j) != '-' && expression.charAt(j) != '*' && expression.charAt(j) != '/'
							&& expression.charAt(j) != '(' && expression.charAt(j) != ')'; j++) {
					}
					Set<Entry<Integer, List<String>>> set1 = treemap.entrySet();
					Iterator<Entry<Integer, List<String>>> iterate1 = set1.iterator();
					iterator1: while (iterate1.hasNext()) {
						@SuppressWarnings("rawtypes")
						Map.Entry me1 = (Map.Entry) iterate1.next();

						previous = treemap.get(me1.getKey());
						// System.out.println(expression+"here it is");
						for (int m = 1; m < previous.size(); m = m + 5) { // System.out.println(previous.get(l)+"comes
							// here12");
							if (expression.substring(i + 2, j).equals(previous.get(m))) { // System.out.println("comes
								// here13");
								if (scope <= Integer.parseInt(previous.get(m + 2))) {
									// System.out.println("\nReached Hereas
									// well");

									String Value = null;
									if (unary.equals("++")) {
										expression = expression.replaceFirst("\\+\\+", "");
										if (previous.get(m - 1).equals("int")) {
											Integer value = Integer.parseInt(previous.get(m + 1)) + 1;
											Value = value.toString();
										}

										else if (previous.get(m - 1).equals("float")) {
											Float value = Float.parseFloat(previous.get(m + 1)) + 1;
											previous.set(m + 1, value.toString());
											Value = value.toString();
										}

										if (previous.get(m - 1).equals("char")) {
											Character value = (char) (Integer.parseInt(previous.get(m + 1)) + 1);
											Value = value.toString();
											symbol.add(value.toString());
										}

									} else if (unary.equals("--")) {
										expression = expression.replaceFirst("\\-\\-", "");
										if (previous.get(m - 1).equals("int")) {
											Integer value = Integer.parseInt(previous.get(m + 1)) - 1;
											Value = value.toString();
										}

										else if (previous.get(m - 1).equals("float")) {
											Float value = Float.parseFloat(previous.get(m + 1)) - 1;
											Value = value.toString();
										}

										if (previous.get(m - 1).equals("char")) {
											Character value = (char) (Integer.parseInt(previous.get(m + 1)) - 1);
											Value = value.toString();
										}
										expression = expression.replaceFirst(expression.substring(i, j - 2), Value);

									}
									symbol.add(previous.get(m - 1));
									symbol.add(previous.get(m));
									symbol.add(Value);
									symbol.add(scope.toString());
									symbol.add(declared.toString());
									m = previous.size() + 1;
									break iterator1;

								}

							}
						}
					}
				}
			}

		symbol = arithmetic(expression, symbol, type, name, previous);
		
return symbol;
	}

	private String opEqual(String tokens) {
		Character operator = tokens.charAt(tokens.indexOf('=') - 1);
		
		String variable = tokens.substring(0, tokens.indexOf(operator));
		variable = variable.replaceAll("[ ]+", "");
		tokens = tokens.replace(operator.toString() + "=", "=" + variable + operator.toString());
		return tokens;
	} 
	private ArrayList<String> arithmetic(String expression, ArrayList<String> symbol, String type, String name,

			List<String> previous) throws ScriptException {
		expression = expression.trim();		String b = "@#$";
		for (int n = 0; n < (expression.length()); n++) {
			if (expression.charAt(n) != ' ' && expression.charAt(n) != '(' && expression.charAt(n) != ')'
					&& expression.charAt(n) != '+' && expression.charAt(n) != '-' && expression.charAt(n) != '*'
					&& expression.charAt(n) != '/' && expression.charAt(n) != '%' && expression.charAt(n) != '.'
					&& !NumberUtils.isDigits(expression.substring(n, n + 1))) {
				int o;
				for (o = n; o < expression.length() && expression.charAt(o) != ' ' && expression.charAt(o) != '('
						&& expression.charAt(o) != ')' && expression.charAt(o) != '+' && expression.charAt(o) != '-'
						&& expression.charAt(o) != '*' && expression.charAt(o) != '/' && expression.charAt(o) != '%'
						&& expression.charAt(o) != '.'; o++) {
				}
				Set<Entry<Integer, List<String>>> set1 = treemap.entrySet();
				Iterator<Entry<Integer, List<String>>> iterate1 = set1.iterator();
				iterator1: while (iterate1.hasNext()) {
					@SuppressWarnings("rawtypes")
					Map.Entry me1 = (Map.Entry) iterate1.next();

					previous = treemap.get(me1.getKey());
					// System.out.println(expression+"here it is");
					for (int m = 1; m < previous.size(); m = m + 5) { // System.out.println(previous.get(l)+"comes
						// here12");
						if (expression.substring(n, o).equals(previous.get(m))) { // System.out.println("comes
							// here13");
							if (scope <= Integer.parseInt(previous.get(m + 2))) {
								// System.out.println("\nReached Hereas well");

								expression = expression.replace(expression.substring(n, o), b);
								expression = expression.replace(b, previous.get(m + 1));
							}
							n = o - 1;
							m = previous.size() + 1;
							break iterator1;

						}

					}

				}
			}

		}
		ScriptEngineManager mgr = new ScriptEngineManager();
		ScriptEngine engine = mgr.getEngineByName("JavaScript");
		String foo = expression;
		String result = engine.eval(foo).toString();
		if (type.equals("int")) {
			// System.out.println("i am here");

			Integer value = (int) Double.parseDouble(result);
			symbol.add(type);
			symbol.add(name);
			symbol.add(value.toString());
		} else if (type.equals("float")) {
			Float value = (float) Double.parseDouble(result);
			symbol.add(type);
			symbol.add(name);
			symbol.add(value.toString());
		} else if (type.equals("char")) {
			Character value = (char) Integer.parseInt(result);
			symbol.add(type);
			symbol.add(name);
			symbol.add(value.toString());
		}
		return symbol;
	}

	
	public static void main(String args[]) throws IOException, ScriptException {
		SymbolTableVersion8 symbolTableVersion3 = new SymbolTableVersion8();
	//	inputFile=args[0];
		//outputFile=args[1];
		symbolTableVersion3.symbolTable();
	}
}
